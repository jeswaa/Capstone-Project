<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Accomodation;
use App\Models\Staff;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ReservationStatusUpdated;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\WalkInGuest;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\DamageReport;
use App\Models\ActivityLog;
use DateTime;

class StaffController extends Controller
{
    public function StaffLogin()
    {
        if (session()->has('StaffLogin')) {
            return redirect()->route('staff.dashboard');
        }
        return view('StaffSide.Stafflogin');
    }
    public function StaffDashboard()
    {
        return view('StaffSide.StaffDashboard');
    }
public function guests(Request $request)
{
    // Base query for users
    $query = DB::table('users');

    // Handle search functionality
    if ($request->has('search')) {
        $search = $request->get('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%'.$search.'%')
              ->orWhere('email', 'LIKE', '%'.$search.'%');
        });
    }

    // Get guests with pagination
    $guests = $query->paginate(10);

    // For each guest, get their reservations
    foreach ($guests as $guest) {
        $guest->reservations = DB::table('reservation_details')
            ->where('user_id', $guest->id)
            ->leftJoin('accomodations', function($join) {
                $join->whereRaw("JSON_CONTAINS(reservation_details.accomodation_id, CONCAT('\"', accomodations.accomodation_id, '\"'))");
            })
            ->select(
                'reservation_details.id',
                'reservation_details.user_id',
                'reservation_details.accomodation_id',
                // ... existing code ...
                'reservation_details.activity_id',
                'reservation_details.reservation_check_in_date',
                'reservation_details.reservation_check_out_date',
                'reservation_details.payment_status',
                'reservation_details.reservation_status',
                'reservation_details.amount',
                'reservation_details.created_at',
                'reservation_details.updated_at',
                DB::raw('GROUP_CONCAT(accomodations.accomodation_name) as accommodation_names')
            )
            ->groupBy(
                'reservation_details.id',
                'reservation_details.user_id',
                'reservation_details.accomodation_id',
                // ... existing code ...
                'reservation_details.activity_id',
                'reservation_details.reservation_check_in_date',
                'reservation_details.reservation_check_out_date',
                'reservation_details.payment_status',
                'reservation_details.reservation_status',
                'reservation_details.amount',
                'reservation_details.created_at',
                'reservation_details.updated_at'
            )
            ->orderBy('reservation_details.created_at', 'desc')
            ->paginate(5);
    }

    return view('StaffSide.StaffGuest', compact('guests'));
}
    public function logout()
    {
        $this->recordActivity('Staff logged out');
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    try {
        $staff = Staff::where('username', $credentials['username'])->first();

        if (!$staff) {
            return back()->withErrors([
                'username' => 'Username not found.'
            ])->withInput();
        }

        // Check if staff account is active
        if ($staff->status === 'inactive') {
            return back()->withErrors([
                'username' => 'This account is inactive. Please contact administrator.'
            ])->withInput();
        }

        // Verify password using Hash::check
        if (!Hash::check($credentials['password'], $staff->password)) {
            return back()->withErrors([
                'password' => 'Invalid password.'
            ])->withInput();
        }

        // Store staff ID in session
        session(['StaffLogin' => $staff->id]);
 
        $this->recordActivity($staff->username . ' logged in');

        return redirect()->route('staff.dashboard')->with('success', 'Login successful!');

    } catch (\Exception $e) {
        \Log::error('Staff authentication error: ' . $e->getMessage());
        return back()->withErrors([
            'error' => 'An error occurred during login. Please try again.'
        ]);
    }
}
private function recordActivity($activity)
{
    // Get current staff info from session
    $staffId = session()->get('StaffLogin');
    $staff = Staff::find($staffId);
    
    // Insert activity log
    DB::table('activity_logs')->insert([
        'date' => now()->toDateString(),
        'time' => now()->toTimeString(),
        'user' => $staff ? $staff->username : 'System', 
        'role' => 'Staff',
        'activity' => $activity,
        'created_at' => now(),
        'updated_at' => now()
    ]);
}

public function dashboard()
{
    if (session()->has('StaffLogin')) {
        $staffCredentials = Staff::where('id', session()->get('StaffLogin'))->first();

        // Get counts for dashboard cards
        $pendingReservations = DB::table('reservation_details')
            ->where('payment_status', 'pending')
            ->where('reservation_status', 'pending')
            ->count();

        $checkedInGuests = DB::table('reservation_details')
            ->where('reservation_status', 'checked-in')
            ->count();

        $availableAccommodations = DB::table('accomodations')
            ->where('accomodation_status', 'available')
            ->count();

        // Get pending reservations list - limited to 3 records with name and date only
        $pendingReservationsList = DB::table('reservation_details')
            ->join('users', 'reservation_details.user_id', '=', 'users.id')
            ->where('reservation_details.payment_status', 'pending')
            ->where('reservation_details.reservation_status', 'pending')
            ->select(
                'users.name as guest_name',
                'reservation_details.reservation_check_in_date',
                'reservation_details.reservation_check_in'
            )
            ->orderBy('reservation_check_in_date')
            ->limit(3)
            ->get();
        
        // Fixed query for today's reservations
        $todayReservations = DB::table('reservation_details')
            ->join('users', 'reservation_details.user_id', '=', 'users.id')
            ->leftJoin('accomodations', function($join) {
                $join->whereRaw("JSON_CONTAINS(reservation_details.accomodation_id, CONCAT('\"', accomodations.accomodation_id, '\"'))");
            })
            ->whereDate('reservation_check_in_date', Carbon::today())
            ->where('reservation_status', 'pending')
            ->select(
                'reservation_details.id',
                'reservation_details.user_id', 
                'reservation_details.reservation_check_in_date',
                'reservation_details.reservation_check_out_date',
                'reservation_details.payment_status',
                'reservation_details.reservation_status',
                'reservation_details.created_at',
                'reservation_details.updated_at',
                'reservation_details.email',
                'reservation_details.reservation_check_in',
                'users.name as guest_name',
                DB::raw('GROUP_CONCAT(accomodations.accomodation_name) as accomodation_name'),
                DB::raw('GROUP_CONCAT(accomodations.room_id) as room_numbers')
            )
            ->groupBy(
                'reservation_details.id',
                'reservation_details.user_id',
                'reservation_details.reservation_check_in_date', 
                'reservation_details.reservation_check_out_date',
                'reservation_details.payment_status',
                'reservation_details.reservation_status',
                'reservation_details.created_at',
                'reservation_details.updated_at',
                'reservation_details.email',
                'reservation_details.reservation_check_in',
                'users.name'
            )
            ->orderBy('reservation_check_in_date')
            ->limit(5)
            ->get();
        return view('StaffSide.StaffDashboard', [
            'staffCredentials' => $staffCredentials,
            'pendingReservations' => $pendingReservations,
            'checkedInGuests' => $checkedInGuests,
            'availableAccommodations' => $availableAccommodations,
            'todayReservations' => $todayReservations,
            'pendingReservationsList' => $pendingReservationsList
        ]);
    } else {
        return redirect()->route('staff.login');
    }
}

// Add new method for handling reservation cancellation
public function cancelReservationWithReason(Request $request, $id)
{
    $request->validate([
        'cancellation_reason' => 'required|string|max:255'
    ]);

    $reservation = DB::table('reservation_details')->where('id', $id)->first();
    
    if ($reservation) {
        DB::table('reservation_details')
            ->where('id', $id)
            ->update([
                'reservation_status' => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'updated_at' => now()
            ]);

        // Free up the accommodation
        $accommodationIds = json_decode($reservation->accomodation_id, true);
        if ($accommodationIds) {
            DB::table('accomodations')
                ->whereIn('accomodation_id', $accommodationIds)
                ->update(['accomodation_status' => 'available']);
        }

        return response()->json(['success' => true, 'message' => 'Reservation cancelled successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Reservation not found']);
}
public function reservations(Request $request)
{
    // Count reservations by status
    $pendingCount = DB::table('reservation_details')
        ->where('reservation_status', 'pending')
        ->count();

    $checkedInCount = DB::table('reservation_details')
        ->where('reservation_status', 'checked-in')
        ->count();

    $checkedOutCount = DB::table('reservation_details')
        ->where('reservation_status', 'checked-out')
        ->count();

    $earlyCheckedOutCount = DB::table('reservation_details')
        ->where('reservation_status', 'early-checked-out')
        ->count();

    $reservedCount = DB::table('reservation_details')
        ->where('reservation_status', 'reserved')
        ->count();

    $totalCount = DB::table('reservation_details')->count();
    $accommodationIdRows = DB::table('reservation_details')->pluck('accomodation_id');
    $allAccommodationIds = [];
    foreach ($accommodationIdRows as $jsonIds) {
        $decoded = json_decode($jsonIds, true);
        if (is_array($decoded)) {
            foreach ($decoded as $id) {
                $allAccommodationIds[] = $id;
            }
        } elseif (is_numeric($decoded)) {
            $allAccommodationIds[] = $decoded;
        }
    }
    $allAccommodationIds = array_unique($allAccommodationIds);

    $accommodationTypes = DB::table('reservation_details')
        ->join('accomodations', function($join) {
            $join->whereRaw("JSON_CONTAINS(reservation_details.accomodation_id, CONCAT('\"', accomodations.accomodation_id, '\"'))");
        })
        ->select('accomodations.accomodation_id', 'accomodations.accomodation_name')
        ->distinct()
        ->get();
    
    // Define the query builder
    $query = DB::table('reservation_details')
        ->leftJoin('accomodations', function($join) {
            $join->whereRaw("JSON_CONTAINS(reservation_details.accomodation_id, CONCAT('\"', accomodations.accomodation_id, '\"'))");
        })
        ->select(
            'reservation_details.*',
            'accomodations.accomodation_name',
            'accomodations.accomodation_price',
        )
        ->orderByDesc('reservation_details.created_at');

    // Add status filter
    if ($request->has('status') && $request->status !== 'all') {
        $query->where('reservation_details.reservation_status', $request->status);
    }

    // Add search functionality
    if ($request->has('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('reservation_details.name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('reservation_details.email', 'LIKE', '%' . $searchTerm . '%');
        });
    }

    // Add stay_type filter
    if ($request->has('stay_type') && $request->stay_type !== '') {
        if ($request->stay_type === 'overnight') {
            $query->whereRaw('reservation_details.reservation_check_in_date <> reservation_details.reservation_check_out_date');
        } elseif ($request->stay_type === 'one_day') {
            $query->whereRaw('reservation_details.reservation_check_in_date = reservation_details.reservation_check_out_date');
        }
    }

    $reservations = $query->paginate(5)->withQueryString();
    // Process each reservation
    foreach ($reservations as $reservation) {
        // --- Handle Activities ---
        $activityIds = json_decode($reservation->activity_id, true);
        $reservation->activities = [];

        if (is_array($activityIds) && count($activityIds) > 0) {
            $reservation->activities = DB::table('activitiestbl')
                ->whereIn('id', $activityIds)
                ->pluck('activity_name')
                ->toArray();
        } elseif (is_numeric($activityIds)) {
            $reservation->activities = DB::table('activitiestbl')
                ->where('id', $activityIds)
                ->pluck('activity_name')
                ->toArray();
        }

        // --- Handle Accommodations ---
        $accommodationIds = json_decode($reservation->accomodation_id, true);
        $reservation->accommodations = [];

        if (is_array($accommodationIds) && count($accommodationIds) > 0) {
            $reservation->accommodations = DB::table('accomodations')
                ->whereIn('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        } elseif (is_numeric($accommodationIds)) {
            $reservation->accommodations = DB::table('accomodations')
                ->where('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        }

        // --- Filter kung Overnight o One Day Stay ---
        if (
            isset($reservation->reservation_check_in_date) &&
            isset($reservation->reservation_check_out_date)
        ) {
            if ($reservation->reservation_check_in_date == $reservation->reservation_check_out_date) {
                $reservation->stay_type = 'One Day Stay';
            } else {
                $reservation->stay_type = 'Overnight';
            }
        } else {
            $reservation->stay_type = 'Unknown';
        }
    }

    // Debugging: Log the fetched details
    \Log::info('All Reservations:', ['reservations' => $reservations]);
    \Log::info('Pending Reservations Count:', ['count' => $pendingCount]);
    \Log::info('Checked-in Reservations Count:', ['count' => $checkedInCount]);
    \Log::info('Checked-out Reservations Count:', ['count' => $checkedOutCount]);
    \Log::info('Total Reservations Count:', ['count' => $totalCount]);

    return view('StaffSide.StaffReservation', compact(
        'reservations',
        'pendingCount',
        'checkedInCount',
        'checkedOutCount',
        'earlyCheckedOutCount',
        'totalCount',
        'accommodationTypes',
        'reservedCount'
    ));
}


public function accomodations()
{
    // Get current staff info
    $staffId = session()->get('StaffLogin');
    $staff = Staff::find($staffId);

    // Fetch all accommodations
    $accomodations = DB::table('accomodations')->paginate(5);
    
    // Compute Room Overview
    $totalRooms = DB::table('accomodations')->sum('quantity');
    $vacantRooms = DB::table('accomodations')
        ->sum('quantity');
        
    $reservedRoomsFromWalkin = DB::table('walkin_guests')
        ->where('reservation_status', 'checked-in')
        ->selectRaw('SUM(quantity) as total_reserved')
        ->value('total_reserved') ?? 0;

    // Add reserved rooms from reservation_details table
    $reservedRoomsFromReservations = DB::table('reservation_details')
    ->whereIn('reservation_status', ['reserved', 'checked-in'])
    ->sum('quantity');

    // Combine both reserved room counts
    $reservedRooms = $reservedRoomsFromWalkin + $reservedRoomsFromReservations;

    // Get reservation details with checkout dates for countdown timer
    $activeReservations = DB::table('reservation_details')
        ->leftJoin('accomodations', function($join) {
            $join->whereRaw("JSON_CONTAINS(reservation_details.accomodation_id, CONCAT('\"', accomodations.accomodation_id, '\"'))");
        })
        ->whereIn('reservation_details.reservation_status', ['reserved', 'checked-in'])
        ->select([
            'reservation_details.accomodation_id',
            'accomodations.accomodation_name',
            'accomodations.quantity as total_quantity', 
            'reservation_details.quantity as reserved_quantity',
            'reservation_details.reservation_check_out_date as next_available_date',
            'reservation_details.reservation_status'
        ])
        ->orderBy('accomodations.accomodation_name')
        ->orderBy('next_available_date')
        ->get()
        ->map(function($item) {
            // Decode the JSON accomodation_id
            $accomIds = json_decode($item->accomodation_id, true);
            $item->accomodation_id = $accomIds[0] ?? null; // Get first ID since we're grouping by it
            return $item;
        })
        ->groupBy('accomodation_id')
        ->map(function ($group) {
            return (object)[
                'id' => $group->first()->accomodation_id,
                'name' => $group->first()->accomodation_name ?? 'No accommodation found',
                'reserved_quantity' => $group->sum('reserved_quantity'),
                'next_available_time' => $group->first()->next_available_date,
                'total_quantity' => $group->first()->total_quantity ?? 0,
                'status' => $group->first()->reservation_status
            ];
        });

    // Optional: Group by accommodation for easier display
    $reservationsByAccommodation = $activeReservations->groupBy('accomodation_id');

    // Record activity with staff username if available, otherwise use 'System'
    $activityUser = $staff ? $staff->username : 'System';
    $this->recordActivity($activityUser . ' viewed accommodations overview - Total: ' . $totalRooms . 
                         ', Vacant: ' . $vacantRooms . 
                         ', Reserved: ' . $reservedRooms);

    return view('StaffSide.StaffsideAccomodations', compact(
        'accomodations', 
        'totalRooms', 
        'vacantRooms', 
        'reservedRooms',
        'activeReservations',
        'reservationsByAccommodation'
    ));
}
public function editRoom(Request $request, $accomodation_id)
{
    // Get current staff info
    $staffId = session()->get('StaffLogin');
    $staff = Staff::find($staffId);
    
    $request->validate([
        'accomodation_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'accomodation_name' => 'required|string|max:255',
        'accomodation_type' => 'required|string',
        'accomodation_capacity' => 'required|numeric|min:1',
        'accomodation_price' => 'required|numeric|min:0',
        'accomodation_status' => 'required|in:available,unavailable,maintenance',
        'accomodation_price' => 'required|numeric|min:0',
        'accomodation_description' => 'nullable|string',
    ]);

    // Find accommodation using Eloquent
    $accomodation = Accomodation::find($accomodation_id);
    if (!$accomodation) {
        return redirect()->back()->with('error', 'Accommodation not found.');
    }

    // Store original values for activity log
    $originalValues = [
        'name' => $accomodation->accomodation_name,
        'type' => $accomodation->accomodation_type,
        'capacity' => $accomodation->accomodation_capacity,
        'price' => $accomodation->accomodation_price,
        'status' => $accomodation->accomodation_status
    ];

    // Handle image upload
    if ($request->hasFile('accomodation_image')) {
        // Delete the old image if it exists
        if ($accomodation->accomodation_image) {
            Storage::delete('public/' . $accomodation->accomodation_image);
        }

        // Store the new image
        $imagePath = $request->file('accomodation_image')->store('public/accomodations');
        $accomodation->accomodation_image = str_replace('public/', '', $imagePath);
    }

    // Update other fields
    $accomodation->accomodation_name = $request->accomodation_name;
    $accomodation->accomodation_type = $request->accomodation_type;
    $accomodation->accomodation_capacity = $request->accomodation_capacity;
    $accomodation->accomodation_price = $request->accomodation_price;
    $accomodation->accomodation_status = $request->accomodation_status;
    $accomodation->accomodation_description = $request->accomodation_description;
    $accomodation->save();

    // Record the activity with changes
    $changes = [];
    if($originalValues['name'] != $request->accomodation_name) {
        $changes[] = "name from '{$originalValues['name']}' to '{$request->accomodation_name}'";
    }
    if($originalValues['type'] != $request->accomodation_type) {
        $changes[] = "type from '{$originalValues['type']}' to '{$request->accomodation_type}'";
    }
    if($originalValues['capacity'] != $request->accomodation_capacity) {
        $changes[] = "capacity from {$originalValues['capacity']} to {$request->accomodation_capacity}";
    }
    if($originalValues['price'] != $request->accomodation_price) {
        $changes[] = "price from {$originalValues['price']} to {$request->accomodation_price}";
    }
    if($originalValues['status'] != $request->accomodation_status) {
        $changes[] = "status from '{$originalValues['status']}' to '{$request->accomodation_status}'";
    }

    $changeLog = !empty($changes) ? " Changes: " . implode(', ', $changes) : "";
    $this->recordActivity($staff->username . " edited accommodation #{$accomodation_id}." . $changeLog);
    
    return redirect()->route('staff.accomodations')->with('success', 'Rooms updated successfully!');
}

    public function bookRoom(Request $request)
    {
        $roomId = $request->input('room_id');
        $room = DB::table('accomodations')->where('accomodation_id', $roomId)->first();

        // Check if room is available
        if ($room->accomodation_slot > 0) {
            // Create the reservation
            $reservationId = DB::table('reservation_details')->insertGetId([
                'user_id' => Auth::id(),
                'accomodation_id' => json_encode([$roomId]), // Store as JSON for multiple rooms
                'reservation_check_in_date' => $request->input('check_in'),
                'reservation_check_out_date' => $request->input('check_out'),
                'created_at' => now(),
            ]);

            // Update the reservation status to booked
            DB::table('reservation_details')->where('id', $reservationId)->update([
                'payment_status' => 'paid',
            ]);

            // Reduce slot only if payment status is booked
            DB::table('accomodations')
                ->where('accomodation_id', $roomId)
                ->whereRaw('accomodation_slot > (SELECT COUNT(*) FROM reservation_details WHERE payment_status = "booked" AND accomodation_id = ?)', [$roomId])
                ->decrement('accomodation_slot');

            return response()->json(['success' => true, 'message' => 'Room booked successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'No slots available for this room.']);
        }
    }

public function cancelReservation($reservationId)
{
    // Get current staff info
    $staffId = session()->get('StaffLogin');
    $staff = Staff::find($staffId);

    $reservation = DB::table('reservation_details')->where('id', $reservationId)->first();

    if ($reservation && in_array($reservation->payment_status, ['cancelled', 'checked_out']) && in_array($reservation->reservation_status, ['Checked-out', 'Cancelled'])) {
        $roomIds = json_decode($reservation->accomodation_id, true);

        // Increase slots for each room booked
        DB::table('accomodations')
            ->whereIn('accomodation_id', $roomIds)
            ->increment('available_slots');

        // Record cancellation activity
        $this->recordActivity($staff->username . " cancelled reservation #{$reservationId} and restored slots for rooms: " . implode(', ', $roomIds));

        // Delete reservation
        DB::table('reservation_details')->where('id', $reservationId)->delete();

        return response()->json(['success' => true, 'message' => 'Reservation canceled, slot restored.']);
    }

    // Record failed cancellation attempt
    if ($staff) {
        $this->recordActivity($staff->username . " attempted to cancel ineligible reservation #{$reservationId}");
    }

    return response()->json(['success' => false, 'message' => 'Reservation not found or not eligible for cancellation.']);
}

    public function UpdateStatus(Request $request, $id)
{
    $staffId = session()->get('StaffLogin');
    $staff = Staff::find($staffId);

    $request->validate([
        'payment_status' => 'required|string',
        'custom_message' => 'nullable|max:255',
        'reservation_status' => 'required|string',
    ]);

    $reservation = DB::table('reservation_details')->where('id', $id)->first();
    if (!$reservation) {
        return redirect()->back()->with('error', 'Reservation not found.');
    }

    $originalPaymentStatus = $reservation->payment_status;
    $originalReservationStatus = $reservation->reservation_status;

    $reservationBeforeUpdate = $reservation;

    $accommodationIdsBeforeUpdate = json_decode($reservationBeforeUpdate->accomodation_id, true) ?? [];
    if (empty($accommodationIdsBeforeUpdate) && !empty($reservationBeforeUpdate->package_id)) {
        $packageRoomsBeforeUpdate = DB::table('packagestbl')
            ->where('id', $reservationBeforeUpdate->package_id)
            ->value('package_room_type');
        $accommodationIdsBeforeUpdate = json_decode($packageRoomsBeforeUpdate, true) ?? [];
    }

    // Start transaction
    DB::beginTransaction();

    try {
        // Update reservation status
        DB::table('reservation_details')->where('id', $id)->update([
            'payment_status' => $request->payment_status,
            'reservation_status' => $request->reservation_status,
            'custom_message' => $request->custom_message ?? null,
            'updated_at' => now(),
        ]);

        $updatedReservation = DB::table('reservation_details')->where('id', $id)->first();

        $accommodationIdsAfterUpdate = json_decode($updatedReservation->accomodation_id, true) ?? [];
        if (empty($accommodationIdsAfterUpdate) && !empty($updatedReservation->package_id)) {
            $packageRoomsAfterUpdate = DB::table('packagestbl')
                ->where('id', $updatedReservation->package_id)
                ->value('package_room_type');
            $accommodationIdsAfterUpdate = json_decode($packageRoomsAfterUpdate, true) ?? [];
        }

        // Handle accommodation quantity when status changes to reserved/checked-in
        if (in_array($request->reservation_status, ['reserved', 'checked-in'])) {
            if (!empty($accommodationIdsAfterUpdate)) {
                foreach ($accommodationIdsAfterUpdate as $accommodationId) {
                    // Deduct quantity
                    $updated = DB::table('accomodations')
                        ->where('accomodation_id', $accommodationId)
                        ->where('quantity', '>', 0)
                        ->decrement('quantity', 1);

                    // Update status if quantity reaches 0
                    if ($updated) {
                        $accommodation = DB::table('accomodations')->where('accomodation_id', $accommodationId)->first();
                        if ($accommodation && $accommodation->quantity <= 0) {
                            DB::table('accomodations')
                                ->where('accomodation_id', $accommodationId)
                                ->update(['accomodation_status' => 'unavailable']);
                        }
                    }
                }
            }
        }

        // Handle quantity return when status changes to cancelled, completed, or checked-out
        if (in_array($originalReservationStatus, ['reserved', 'checked-in']) && 
            in_array($request->reservation_status, ['cancelled','checked-out'])) {
            if (!empty($accommodationIdsBeforeUpdate)) {
                foreach ($accommodationIdsBeforeUpdate as $accommodationId) {
                    // Return quantity
                    DB::table('accomodations')
                        ->where('accomodation_id', $accommodationId)
                        ->increment('quantity', 1);

                    // Update status if quantity goes from 0 to 1
                    DB::table('accomodations')
                        ->where('accomodation_id', $accommodationId)
                        ->where('accomodation_status', 'unavailable')
                        ->update(['accomodation_status' => 'available']);
                }
            }
        }

        $statusChanges = [];
        if ($originalPaymentStatus != $request->payment_status) {
            $statusChanges[] = "payment status from '{$originalPaymentStatus}' to '{$request->payment_status}'";
        }
        if ($originalReservationStatus != $request->reservation_status) {
            $statusChanges[] = "reservation status from '{$originalReservationStatus}' to '{$request->reservation_status}'";
        }

        $changeLog = !empty($statusChanges) ? " Changes: " . implode(', ', $statusChanges) : "";

        if ($staff && $staff->username) {
            $this->recordActivity($staff->username . " updated reservation #{$id}." . $changeLog);
        } else {
            $this->recordActivity("Unknown staff updated reservation #{$id}." . $changeLog);
        }

        DB::commit();

        Mail::to($updatedReservation->email)->send(new ReservationStatusUpdated(
            $updatedReservation,
            $request->custom_message,
            $updatedReservation
        ));

        return redirect()->route('staff.reservation')->with('success', 'Reservation status updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to update reservation: ' . $e->getMessage());
    }
}
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'reservation_id' => 'nullable|exists:reservations,id', // Validate reservation ID if provided
        ]);

        // Fetch reservation details if an ID is provided
        $reservationDetails = null;
        if ($request->has('reservation_id')) {
            $reservationDetails = Reservation::select('reservation_details.*', 'accomodations.accomodation_name', 'accomodations.accomodation_type', 'accomodations.accomodation_capacity', 'accomodations.accomodation_price', 'accomodations.accomodation_status', 'accomodations.accomodation_slot', 'accomodations.accomodation_image', 'activities.activity_name', 'packages.package_room_type', 'packages.package_max_guests', 'packages.package_name')
                ->leftJoin('accomodations', 'reservation_details.accomodation_id', '=', 'accomodations.accomodation_id')
                ->leftJoin('activitiestbl AS activities', 'reservation_details.activity_id', '=', 'activities.id')
                ->leftJoin('packagestbl AS packages', 'reservation_details.package_id', '=', 'packages.id')
                ->findOrFail($request->reservation_id);
        }

        // Send email with reservation details
        Mail::to($request->email)->send(new SendEmail($request->subject, $request->message, $reservationDetails));

        return redirect()->route('staff.reservation')->with('success', 'Email sent successfully!');
    }

    public function walkIn()
    {
        // Get all transactions ordered by most recent first
        $transactions = DB::table('transaction')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get latest adult and kid transactions (most recent entrance fees)
        $adultTransaction = DB::table('transaction')
            ->where('type', 'adult')
            ->latest()
            ->first();

        $kidTransaction = DB::table('transaction')
            ->where('type', 'kid')
            ->latest()
            ->first();

        // Log latest transactions (for debugging)
        \Log::info('Adult Transaction:', ['transaction' => $adultTransaction]);
        \Log::info('Kid Transaction:', ['transaction' => $kidTransaction]);

        // Extract first start_time and end_time from transactions
        $start_time = $transactions->pluck('start_time')->first();
        $end_time = $transactions->pluck('end_time')->first();

        // Get walk-in guests with their accommodation name
        $walkinGuest = DB::table('walkin_guests')
            ->leftJoin('accomodations', 'walkin_guests.accomodation_id', '=', 'accomodations.accomodation_id')
            ->select('walkin_guests.*', 'accomodations.accomodation_name')
            ->paginate(5);

        // Guest status counts
        $totalWalkInGuests = $walkinGuest->count();
        $totalCheckedInGuests = $walkinGuest->where('reservation_status', 'checked-in')->count();
        $totalCheckedOutGuests = $walkinGuest->where('reservation_status', 'checked-out')->count();

        // Get available accommodations
        $accomodations = DB::table('accomodations')
            ->where('accomodation_status', 'available')
            ->get();

        // Return data to view
        return view('StaffSide.walkIn', compact(
            'transactions', 
            'accomodations', 
            'walkinGuest', 
            'totalWalkInGuests', 
            'totalCheckedInGuests', 
            'totalCheckedOutGuests', 
            'start_time', 
            'end_time',
            'adultTransaction',
            'kidTransaction'
        ));
    }

    public function walkInAdd(Request $request)
    {
        try {
            // Validate input first (basic validation rules)
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'mobileNo' => 'required|string',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after_or_equal:check_in_date',
                'accomodation_id' => 'required|array',
                'accomodation_id.*' => 'exists:accomodations,accomodation_id',
                'number_of_adults' => 'required|integer|min:0',
                'number_of_children' => 'required|integer|min:0',
                'payment_status' => 'required',
                'payment_method' => 'required|string',
                'quantity' => 'required|integer|min:1'
            ]);
            // Calculate total guests
            $total_guests = $request->number_of_adults + $request->number_of_children;

            // Create reservation
            $reservation = DB::table('walkin_guests')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'mobileNo' => $request->mobileNo,
                'reservation_check_in_date' => $request->check_in_date,
                'reservation_check_out_date' => $request->check_out_date,
                'accomodation_id' => json_encode($request->accomodation_id),
                'number_of_adult' => $request->number_of_adults,
                'number_of_children' => $request->number_of_children,
                'total_guests' => $total_guests,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'reservation_status' => 'checked-in',
                'reservation_type' => 'walk-in',
                'quantity' => $request->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update each accommodation's status
            foreach ($request->accomodation_id as $accomId) {
                DB::table('accomodations')
                    ->where('accomodation_id', $accomId)
                    ->update(['accomodation_status' => 'unavailable']);
            }

            // Log activity
            $staffId = session()->get('StaffLogin');
            $staff = Staff::find($staffId);
            $this->recordActivity($staff->username . " added walk-in reservation #" . $reservation);

            return response()->json([
                'success' => true,
                'message' => 'Walk-in reservation added successfully',
                'reservation_id' => $reservation
            ]);

        } catch (\Exception $e) {
            \Log::error('Walk-in guest registration error: ' . $e->getMessage());
            return back()->with('error', 'Error adding walk-in reservation: ' . $e->getMessage())->withInput();
        }
    }

    public function storeWalkInGuest(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'mobileNo' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'check_in_time' => 'required',
                'check_out_time' => 'required',
                'accomodation_id' => 'required',
                'number_of_adult' => 'required|integer|min:0',
                'number_of_children' => 'required|integer|min:0',
                'payment_status' => 'required',
                'reservation_status' => 'required',
                'payment_method' => 'required|string|in:cash,gcash',
                'amount' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:1'
            ]);
            // Get accommodation details
            $accommodation = DB::table('accomodations')
                ->where('accomodation_id', $validated['accomodation_id'])
                ->first();
                
            // Check if accommodation exists
            if (!$accommodation) {
                return back()->with('error', 'Selected accommodation not found.');
            }   

            // Check if there's enough quantity available
            if ($accommodation->quantity < $validated['quantity']) {
                return back()->with('error', 'Not enough rooms available. Only ' . $accommodation->quantity . ' rooms left.');
            }
            
            // Calculate total guests
            $totalGuests = $validated['number_of_adult'] + $validated['number_of_children'];
            
            // Create a walk-in guest record
            $walkInGuest = DB::table('walkin_guests')->insert([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'mobileNo' => $validated['mobileNo'],
                'reservation_check_in_date' => $validated['check_in_date'],
                'reservation_check_out_date' => $validated['check_out_date'],
                'check_in_time' => $validated['check_in_time'],
                'check_out_time' => $validated['check_out_time'],
                'number_of_adult' => $validated['number_of_adult'],
                'number_of_children' => $validated['number_of_children'],
                'quantity' => $validated['quantity'],
                'total_guests' => $totalGuests,
                'payment_status' => $validated['payment_status'],
                'reservation_status' => $validated['reservation_status'],
                'accomodation_id' => $validated['accomodation_id'],
                'payment_method' => $validated['payment_method'],
                'amount' => $validated['amount']
            ]);
            
            // Update accommodation quantity
            $newQuantity = $accommodation->quantity - $validated['quantity'];
            DB::table('accomodations')
                ->where('accomodation_id', $validated['accomodation_id'])
                ->update([
                    'quantity' => $newQuantity,
                    'accomodation_status' => $newQuantity > 0 ? 'available' : 'unavailable'
                ]);

            // Record activity
            $this->recordActivity("Created walk-in reservation for {$validated['name']}");

            return back()->with('success', 'Reservation added successfully');
        } catch (\Exception $e) {
            \Log::error('Walk-in guest registration error: ' . $e->getMessage());
            return back()->with('error', 'Error adding walk-in reservation: ' . $e->getMessage());
        }
    }
    
    public function updateWalkInStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'payment_status' => 'required',
                'reservation_status' => 'required'
            ]);
    
            $walkInGuest = DB::table('walkin_guests')->where('id', $id)->first();
            if (!$walkInGuest) {
                return redirect()->back()->with('error', 'Walk-in guest not found.');
            }
    
            $originalStatus = [
                'payment' => $walkInGuest->payment_status,
                'reservation' => $walkInGuest->reservation_status
            ];
    
            DB::table('walkin_guests')
                ->where('id', $id)
                ->update([
                    'payment_status' => $request->payment_status,
                    'reservation_status' => $request->reservation_status,
                ]);
    
            if ($request->reservation_status === 'checked-out' && $originalStatus['reservation'] !== 'checked-out') {
                $accommodation = DB::table('accomodations')
                    ->where('accomodation_id', $walkInGuest->accomodation_id)
                    ->first();
    
                if ($accommodation) {
                    $newQuantity = $accommodation->quantity + $walkInGuest->quantity;
    
                    DB::table('accomodations')
                        ->where('accomodation_id', $walkInGuest->accomodation_id)
                        ->update([
                            'quantity' => $newQuantity,
                            'accomodation_status' => 'available'
                        ]);
                }
            }
    
            $staffId = session()->get('StaffLogin');
            $staff = Staff::find($staffId);
            if (!$staff) {
                return redirect('/login')->with('error', 'Session expired or staff not found. Please log in again.');
            }
    
            DB::table('activity_logs')->insert([
                'activity' => 'Updated walk-in guest status for ' . $walkInGuest->name . ' to ' . $request->reservation_status,
                'user' => $staff->username,
                'role' => $staff->role,
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
           return redirect()->back()->with('success', 'Walk-in guest status updated successfully');
    
        } catch (\Exception $e) {
            \Log::error('Error updating walk-in guest status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update walk-in guest status');
        }
    }
    


    public function getNotifications()
    {
        // Kunin ang mga bagong reservations sa nakalipas na 24 oras
        $recentReservations = DB::table('reservation_details')
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($recentReservations as $reservation) {
            // Hanapin kung may existing notification para sa reservation na ito
            $existingNotification = DB::table('notifications')
                ->where('reservation_id', $reservation->id)
                ->where('type', 'reservation')
                ->first();

            // Kung wala pa, insert bagong notification
            if (!$existingNotification) {
                DB::table('notifications')->insert([
                    'type' => 'reservation',
                    'reservation_id' => $reservation->id,
                    'message' => "New reservation from {$reservation->name} for " .
                                Carbon::parse($reservation->reservation_check_in_date)->format('M d, Y'),
                    'for_role' => 'staff',
                    'is_read' => false,
                    'created_at' => $reservation->created_at,
                    'updated_at' => now(),
                ]);
            } else {
                // Optional: update message or created_at if needed, but DON'T reset is_read
                DB::table('notifications')
                    ->where('id', $existingNotification->id)
                    ->update([
                        'message' => "New reservation from {$reservation->name} for " .
                                    Carbon::parse($reservation->reservation_check_in_date)->format('M d, Y'),
                        'created_at' => $reservation->created_at,
                        'updated_at' => now()
                    ]);
            }
        }

        // Kunin lang ang mga hindi pa nababasang notifications
        $unreadNotifications = DB::table('notifications')
            ->where('for_role', 'staff')
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($unreadNotifications);
    }


    public function markNotificationAsRead($id)
    {
        $notification = DB::table('notifications')->where('id', $id)->first();

        if ($notification) {
            DB::table('notifications')
                ->where('id', $id)
                ->update([
                    'is_read' => true,
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification not found'
        ], 404);
    }
    public function updatedSessionFees(Request $request)
{
    try {
        // Validate the input to make sure 'session' is provided
        $request->validate([
            'session' => 'required|string'
        ]);

        $session = $request->input('session');

        // Get entrance fee for adult
        $adultFee = DB::table('transaction')
            ->where('type', 'adult')
            ->where('session', $session)
            ->value('entrance_fee') ?? 0;

        // Get entrance fee for kid
        $childFee = DB::table('transaction')
            ->where('type', 'kid')
            ->where('session', $session)
            ->value('entrance_fee') ?? 0;

        return response()->json([
            'success' => true,
            'adult_fee' => number_format($adultFee, 2, '.', ''),
            'child_fee' => number_format($childFee, 2, '.', '')
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching entrance fees.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function DamageReport()
    {
        $damageReports = DamageReport::orderBy('created_at', 'desc')
            ->paginate(5);

        return view('StaffSide.StaffDamageReport', compact('damageReports'));
    }
    public function storeDamageReport(Request $request)
    {
        $request->validate([
            'notes' => 'required|string|max:255',
            'damage_description' => 'required|string',
            'status' => 'required',
            'damage_photos' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle image upload
        $photoPath = null;
        if ($request->hasFile('damage_photos')) {
            $photoPath = $request->file('damage_photos')->store('public/damage_photos');
            $photoPath = str_replace('public/', '', $photoPath);
        }

        // Create the damage report
        DamageReport::create([
            'notes' => $request->notes,
            'damage_description' => $request->damage_description,
            'status' => $request->status,
            'damage_photos' => $photoPath,
        ]);

        // Optionally, record activity
        $this->recordActivity('Added a new damage report with notes: ' . $request->notes);

        return redirect()->back()->with('success', 'Damage report submitted successfully!');
    }
    public function editDamageReport(Request $request, $id)
{
    try {
        // Log the incoming request data
        Log::info('Damage Report Update - Request Data:', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        // Validate the request
        $request->validate([
            'notes' => 'required|string',
            'damage_description' => 'required|string',
            'status' => 'required'
        ]);

        // Get the damage report
        $damageReport = DamageReport::find($id);
        if (!$damageReport) {
            throw new \Exception('Damage report not found');
        }

        // Update the damage report
        $updated = $damageReport->update([
            'notes' => $request->notes,
            'damage_description' => $request->damage_description,
            'status' => $request->status,
            'updated_at' => now()
        ]);

        // Log the update result
        Log::info('Damage Report Update - Result:', [
            'id' => $id,
            'updated' => $updated
        ]);

        if ($updated) {
            // Record the activity
            $staffId = session()->get('StaffLogin');
            $staff = Staff::find($staffId);
            if ($staff) {
                $this->recordActivity($staff->username . ' updated damage report #' . $id);
            }

            return redirect()->back()->with('success', 'Damage report updated successfully');
        }

        return redirect()->back()->with('error', 'No changes were made to the damage report');
    } catch (\Exception $e) {
        // Log the error
        Log::error('Damage Report Update - Error:', [
            'id' => $id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Error updating damage report: ' . $e->getMessage());
    }
}
    
    public function AutoCancellation()
    {
        $today = now()->format('Y-m-d');
        $cutoffTime = now()->subHours(24);
        
        $reservations = Reservation::where('reservation_status', 'reserved')
        ->whereDate('reservation_check_in_date', '<=', now()->toDateString())
        ->where('created_at', '<=', now()->subHours(24))
        ->get();

        $cancelledCount = 0;

        foreach ($reservations as $reservation) {
            $reservation->reservation_status = 'cancelled';
            $reservation->save();
            $cancelledCount++;
        }

        return redirect()->back()->with('error', 'Auto cancellation process completed. ' . $cancelledCount . ' reservations were cancelled.');
    }

    public function ExtendReservation(Request $request, $reservationId)
    {
        try {
            // Validate request
            $request->validate([
                'new_checkout_date' => 'required|date',
                'additional_payment' => 'required|numeric|min:0'
            ]);

            // Get the reservation
            $reservation = DB::table('reservation_details')->where('id', $reservationId)->first();
            
            if (!$reservation) {
                return redirect()->back()->with('error', 'Reservation not found');
            }

            // Check if the accommodation is available for the extended period
            $accommodationIds = json_decode($reservation->accomodation_id, true);
            $conflictingReservations = DB::table('reservation_details')
                ->where('id', '!=', $reservationId)
                ->where(function($query) use ($request, $reservation) {
                    $query->whereBetween('reservation_check_in_date', [$reservation->reservation_check_out_date, $request->new_checkout_date])
                        ->orWhereBetween('reservation_check_out_date', [$reservation->reservation_check_out_date, $request->new_checkout_date]);
                })
                ->whereRaw("JSON_CONTAINS(accomodation_id, ?)", [json_encode($accommodationIds)])
                ->exists();

            if ($conflictingReservations) {
                return redirect()->back()->with('error', 'Accommodation not available for the extended period');
            }

            // Update reservation
            DB::table('reservation_details')
                ->where('id', $reservationId)
                ->update([
                    'reservation_check_out_date' => $request->new_checkout_date,
                    'amount' => DB::raw('amount + ' . $request->additional_payment),
                    'updated_at' => now()
                ]);

            // Record activity
            $this->recordActivity('Extended reservation #' . $reservationId . ' to ' . $request->new_checkout_date);
            
            return redirect()->back()->with('success', 'Reservation extended successfully');

        } catch (\Exception $e) {
            \Log::error('Error extending reservation: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while extending the reservation');
        }
    }
public function checkDateAvailability(Request $request)
{
    try {
        $date = $request->input('date');
        $accommodationId = $request->input('accommodation_id');
        $requestedQuantity = $request->input('quantity', 1);

        if (!$this->isValidDate($date) || Carbon::parse($date)->isPast()) {
            return response()->json([
                'available' => false,
                'message' => 'Invalid or past date.'
            ]);
        }

        $isAvailable = $accommodationId 
            ? $this->checkAccommodationAvailability($date, $accommodationId, $requestedQuantity)
            : $this->checkAnyAvailability($date);

        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Available' : 'Not available for selected date'
        ]);
    } catch (\Exception $e) {
        \Log::error('Availability check error: ' . $e->getMessage());
        return response()->json([
            'available' => false,
            'message' => 'Error checking availability'
        ]);
    }
}
private function checkAccommodationAvailability($date, $accommodationId, $requestedQuantity)
{
    $accommodation = Accomodation::find($accommodationId);
    
    if (!$accommodation || $accommodation->accomodation_status !== 'available') {
        return false;
    }
    
    // Check walk-in reservations that overlap with selected date
    $walkInReservations = WalkInGuest::where('accomodation_id', $accommodationId)
        ->where('reservation_check_in_date', '<=', $date)
        ->where('reservation_check_out_date', '>', $date)
        ->whereIn('reservation_status', ['reserved', 'checked-in'])
        ->sum('quantity');
    
    // Check online reservations that overlap with selected date
    $onlineReservations = Reservation::where('accomodation_id', $accommodationId)
        ->where('reservation_check_in_date', '<=', $date)
        ->where('reservation_check_out_date', '>', $date)
        ->whereIn('reservation_status', ['reserved', 'checked-in'])
        ->sum('quantity');
    
    $totalReserved = $walkInReservations + $onlineReservations;
    $availableRooms = $accommodation->accomodation_capacity - $totalReserved;
    
    return $availableRooms >= $requestedQuantity;
}

private function checkAnyAvailability($date)
{
    $accommodations = Accomodation::where('accomodation_status', 'available')->get();
    
    foreach ($accommodations as $accommodation) {
        if ($this->checkAccommodationAvailability($date, $accommodation->accomodation_id, 1)) {
            return true;
        }
    }
    
    return false;
}

private function isValidDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}
}