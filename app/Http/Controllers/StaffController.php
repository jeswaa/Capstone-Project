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
        $query = DB::table('users');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%'.$search.'%')
                  ->orWhere('email', 'LIKE', '%'.$search.'%');
            });
        }

        $guests = $query->paginate(10); // Add pagination with 10 items per page
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
        ->leftJoin('accomodations', 'reservation_details.accomodation_id', '=', 'accomodations.accomodation_id')
        ->leftJoin('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
        ->select(
            'reservation_details.*',
            'accomodations.accomodation_name',
            'packagestbl.package_name',
            'packagestbl.package_activities',
            'packagestbl.package_room_type'                
        )
        ->orderByDesc('reservation_details.created_at');

    // Add search functionality
    if ($request->has('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('reservation_details.name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('reservation_details.email', 'LIKE', '%' . $searchTerm . '%');
        });
    }

    $reservations = $query->paginate(5)->withQueryString();

    $archivedReservations = DB::table('archived_reservations')->latest()->get();

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
    }
    // Debugging: Log the fetched details
    \Log::info('All Reservations:', ['reservations' => $reservations]);
    \Log::info('Pending Reservations Count:', ['count' => $pendingCount]);
    \Log::info('Checked-in Reservations Count:', ['count' => $checkedInCount]);
    \Log::info('Checked-out Reservations Count:', ['count' => $checkedOutCount]);
    \Log::info('Total Reservations Count:', ['count' => $totalCount]);

    return view('StaffSide.StaffReservation', compact(
        'reservations', 
        'archivedReservations', 
        'pendingCount',
        'checkedInCount',
        'checkedOutCount', 
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

    // Extract accommodation IDs
    $accommodationIds = json_decode($reservation->accomodation_id, true) ?? [];

    if (empty($accommodationIds) && !empty($reservation->package_id)) {
        $packageRooms = DB::table('packagestbl')
            ->where('id', $reservation->package_id)
            ->value('package_room_type');

        $accommodationIds = json_decode($packageRooms, true) ?? [];
    }

    // Update payment and reservation status independently
    DB::table('reservation_details')->where('id', $id)->update([
        'payment_status' => $request->payment_status,
        'reservation_status' => $request->reservation_status,
        'custom_message' => $request->custom_message ?? null,
        'updated_at' => now(),
    ]);

    // Refresh reservation data after update
    $updatedReservation = DB::table('reservation_details')->where('id', $id)->first();

    // Update accommodation status based on reservation status
    if ($request->reservation_status === 'checked-in') {
        DB::table('accomodations')
            ->whereIn('accomodation_id', $accommodationIds)
            ->update(['accomodation_status' => 'unavailable']);
    } elseif (in_array($request->reservation_status, ['checked-out', 'cancelled'])) {
        DB::table('accomodations')
            ->whereIn('accomodation_id', $accommodationIds)
            ->update(['accomodation_status' => 'available']);
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
}