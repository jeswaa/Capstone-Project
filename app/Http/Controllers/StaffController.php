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
            'accomodations.accomodation_name'
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
        'accommodationTypes'
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
    $totalRooms = DB::table('accomodations')->count();
    $vacantRooms = DB::table('accomodations')->where('accomodation_status', 'available')->count();

    // Adjust reservedRooms count and update available slots
    $reservedRooms = DB::table('accomodations')
        ->where('accomodation_status', 'unavailable')
        ->count();

    // Record activity
    $this->recordActivity($staff->username . ' viewed accommodations overview - Total: ' . $totalRooms . 
                         ', Vacant: ' . $vacantRooms . 
                         ', Reserved: ' . $reservedRooms);

    return view('StaffSide.StaffsideAccomodations', compact('accomodations', 'totalRooms', 'vacantRooms', 'reservedRooms'));
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
    // Get current staff info
    $staffId = session()->get('StaffLogin');
    $staff = Staff::find($staffId);

    // Validate input
    $request->validate([
        'payment_status' => 'required|string',
        'custom_message' => 'nullable|max:255', 
        'reservation_status' => 'required|string',
    ]);

    // Fetch reservation details
    $reservation = DB::table('reservation_details')->where('id', $id)->first();
    if (!$reservation) {
        return redirect()->back()->with('error', 'Reservation not found.');
    }

    // Store original status values for activity log
    $originalPaymentStatus = $reservation->payment_status;
    $originalReservationStatus = $reservation->reservation_status;

    // Fetch reservation details BEFORE update to compare statuses
    $reservationBeforeUpdate = DB::table('reservation_details')->where('id', $id)->first();
    if (!$reservationBeforeUpdate) {
        return redirect()->back()->with('error', 'Reservation not found.');
    }

    // Store original status values for activity log
    $originalPaymentStatus = $reservationBeforeUpdate->payment_status;
    $originalReservationStatus = $reservationBeforeUpdate->reservation_status;

    // Extract accommodation IDs from the reservation BEFORE update
    $accommodationIdsBeforeUpdate = json_decode($reservationBeforeUpdate->accomodation_id, true) ?? [];
    if (empty($accommodationIdsBeforeUpdate) && !empty($reservationBeforeUpdate->package_id)) {
        $packageRoomsBeforeUpdate = DB::table('packagestbl')
            ->where('id', $reservationBeforeUpdate->package_id)
            ->value('package_room_type');
        $accommodationIdsBeforeUpdate = json_decode($packageRoomsBeforeUpdate, true) ?? [];
    }

    // Update payment and reservation status
    DB::table('reservation_details')->where('id', $id)->update([
        'payment_status' => $request->payment_status,
        'reservation_status' => $request->reservation_status,
        'custom_message' => $request->custom_message ?? null,
        'updated_at' => now(),
    ]);

    // Refresh reservation data AFTER update
    $updatedReservation = DB::table('reservation_details')->where('id', $id)->first();

    // Extract accommodation IDs from the reservation AFTER update
    $accommodationIdsAfterUpdate = json_decode($updatedReservation->accomodation_id, true) ?? [];
    if (empty($accommodationIdsAfterUpdate) && !empty($updatedReservation->package_id)) {
        $packageRoomsAfterUpdate = DB::table('packagestbl')
            ->where('id', $updatedReservation->package_id)
            ->value('package_room_type');
        $accommodationIdsAfterUpdate = json_decode($packageRoomsAfterUpdate, true) ?? [];
    }

    // --- Adjust Accommodation Quantities and Statuses ---
    $oldStatus = $originalReservationStatus;
    $newStatus = $request->reservation_status;

    // If status changed TO 'reserved' or 'checked-in' from a non-active status
    if (in_array($newStatus, ['reserved', 'checked-in']) && !in_array($oldStatus, ['reserved', 'checked-in'])) {
        if (!empty($accommodationIdsAfterUpdate)) {
            foreach ($accommodationIdsAfterUpdate as $accomodationId) {
                // Decrement quantity for each room type in the reservation
                // Assuming quantity in reservation_details is the number of rooms of this type, default to 1 if not present
                $decrementQuantity = $updatedReservation->quantity ?? 1;
                 DB::table('accomodations')
                    ->where('accomodation_id', $accomodationId)
                    ->decrement('quantity', $decrementQuantity);
            }
        }
    }
    // If status changed FROM 'reserved' or 'checked-in' to 'checked-out' or 'cancelled' or 'early-checked-out'
    elseif (in_array($oldStatus, ['reserved', 'checked-in']) && in_array($newStatus, ['checked-out', 'cancelled', 'early-checked-out'])) {
         if (!empty($accommodationIdsBeforeUpdate)) {
            foreach ($accommodationIdsBeforeUpdate as $accomodationId) {
                // Increment quantity for each room type in the reservation
                // Assuming quantity in reservation_details is the number of rooms of this type, default to 1 if not present
                $incrementQuantity = $reservationBeforeUpdate->quantity ?? 1;
                 DB::table('accomodations')
                    ->where('accomodation_id', $accomodationId)
                    ->increment('quantity', $incrementQuantity);
            }
        }
    }

    // After adjusting quantities, update accommodation status based on the NEW quantity
    $allInvolvedAccommodationIds = array_unique(array_merge($accommodationIdsBeforeUpdate, $accommodationIdsAfterUpdate));

    if (!empty($allInvolvedAccommodationIds)) {
        foreach ($allInvolvedAccommodationIds as $accomodationId) {
             $currentQuantity = DB::table('accomodations')
                                ->where('accomodation_id', $accomodationId)
                                ->value('quantity');

            $newAccomodationStatus = $currentQuantity > 0 ? 'available' : 'unavailable';

            DB::table('accomodations')
                ->where('accomodation_id', $accomodationId)
                ->update(['accomodation_status' => $newAccomodationStatus]);
        }
    }

    // Record the status update activity
    $statusChanges = [];
    if ($originalPaymentStatus != $request->payment_status) {
        $statusChanges[] = "payment status from '{$originalPaymentStatus}' to '{$request->payment_status}'";
    }
    if ($originalReservationStatus != $request->reservation_status) {
        $statusChanges[] = "reservation status from '{$originalReservationStatus}' to '{$request->reservation_status}'";
    }
    
    $changeLog = !empty($statusChanges) ? " Changes: " . implode(', ', $statusChanges) : "";
    $this->recordActivity($staff->username . " updated reservation #{$id}." . $changeLog);

    // Send email notification
    Mail::to($updatedReservation->email)->send(new ReservationStatusUpdated(
        $updatedReservation,
        $request->custom_message,
        $updatedReservation
    ));

    return redirect()->route('staff.reservation')->with('success', 'Reservation status updated successfully!');
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
        // Get all transactions
        $transactions = DB::table('transaction')->get();

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
                'payment_status' => 'required|in:pending,paid',
                'payment_method' => 'required|string'
            ]);

            // Calculate total guests
            $total_guests = $request->number_of_adults + $request->number_of_children;

            // Create reservation record
            $reservation = DB::table('walkin_guests')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'mobileNo' => $request->mobileNo,
                'reservation_check_in_date' => $request->check_in_date,
                'reservation_check_out_date' => $request->check_out_date,
                'accomodation_id' => json_encode($request->accomodation_id),
                'number_of_adult' => $request->number_of_adult,
                'number_of_children' => $request->number_of_children,
                'total_guests' => $total_guests,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'reservation_status' => 'pending',
                'reservation_type' => 'walk-in',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Update accommodation status
            foreach ($request->accomodation_id as $accomId) {
                DB::table('accomodations')
                    ->where('accomodation_id', $accomId)
                    ->update(['accomodation_status' => 'unavailable']);
            }

            // Record activity
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
            return back()->with('error', 'Error adding walk-in reservation: ' . $e->getMessage());
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
                'check_in_time' => 'required',  // Add validation for check_in_time
                'check_out_time' => 'required', // Add validation for check_out_time
                'accomodation_id' => 'required',
                'number_of_adult' => 'required|integer|min:0',
                'number_of_children' => 'required|integer|min:0',
                'payment_method' => 'required|string|in:cash,gcash',
                'amount' => 'required|numeric|min:0'
            ]);
            
            // Calculate total guests
            $total_guests = $validated['number_of_adult'] + $validated['number_of_children'];
            
            // Create a walk-in guest record
            $walkInGuest = WalkInGuest::create([
                'name' => $validated['name'],
                'address' => $validated['address'],
                'mobileNo' => $validated['mobileNo'],
                'reservation_check_in_date' => $validated['check_in_date'],
                'reservation_check_out_date' => $validated['check_out_date'],
                'check_in_time' => $validated['check_in_time'],
                'check_out_time' => $validated['check_out_time'],
                'number_of_adult' => $validated['number_of_adult'],
                'number_of_children' => $validated['number_of_children'],
                'total_guests' => $total_guests,
                'payment_status' => 'paid',
                'reservation_status' => 'checked-in',
                'accomodation_id' => $validated['accomodation_id'],
                'payment_method' => $validated['payment_method'],
                'amount' => $validated['amount']
            ]);

            // Update accommodation status
            DB::table('accomodations')
                ->where('accomodation_id', $validated['accomodation_id'])
                ->update(['accomodation_status' => 'unavailable']);

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
            // Validate request
            $request->validate([
                'payment_status' => 'required',
                'reservation_status' => 'required'
            ]);

            // Find the walk-in guest record
            $walkInGuest = WalkInGuest::findOrFail($id);

            // Store original values for activity log
            $originalStatus = [
                'payment' => $walkInGuest->payment_status,
                'reservation' => $walkInGuest->reservation_status
            ];

            // Update the statuses
            $walkInGuest->payment_status = $request->payment_status;
            $walkInGuest->reservation_status = $request->reservation_status;
            $walkInGuest->save();

            // Get current staff info
            $staffId = session()->get('StaffLogin');
            $staff = Staff::find($staffId);

            // Record the activity
            $changes = [];
            if ($originalStatus['payment'] != $request->payment_status) {
                $changes[] = "payment status from '{$originalStatus['payment']}' to '{$request->payment_status}'";
            }
            if ($originalStatus['reservation'] != $request->reservation_status) {
                $changes[] = "reservation status from '{$originalStatus['reservation']}' to '{$request->reservation_status}'";
            }

            if (!empty($changes)) {
                $this->recordActivity($staff->username . ' updated walk-in guest #' . $id . ': ' . implode(', ', $changes));
            }

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
    

}