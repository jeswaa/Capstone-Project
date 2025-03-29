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

class StaffController extends Controller
{
    public function StaffLogin()
    {
        return view('StaffSide.Stafflogin');
    }
    public function StaffDashboard()
    {
        return view('StaffSide.StaffDashboard');
    }
    public function guests()
    {
        $users = DB::table('users')->get();
        return view('StaffSide.StaffGuest', compact('users'));
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('staff.login')->with('success', 'Logged out successfully!');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Staff::where('username', $credentials['username'])->exists()) {
            $staff = Staff::where('username', $credentials['username'])->first();

            if ($staff && $staff->password == $credentials['password']) {
                session()->put('StaffLogin', $staff->id);
                return redirect()->route('staff.dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        if (session()->has('StaffLogin')) {
            $staffCredentials = Staff::where('id', session()->get('StaffLogin'))->first();

            $users = DB::table('users')->get();
            $totalUsers = $users->count();
            $totalGuests = DB::table('users')->count();
            $totalReservations = DB::table('reservation_details')->count();

            $reservationData = DB::table('reservation_details')
                ->select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month"))
                ->groupBy('month')
                ->get();

            $totalTransactions = DB::table('reservation_details')
                ->where('payment_status', 'Paid') // Filter only completed payments
                ->count();


            $totalPaidTransactions = DB::table('reservation_details')
                ->where('payment_status', 'Paid') // Filter only completed payments
                ->count();

            return view('StaffSide.StaffDashboard', [
                'staffCredentials' => $staffCredentials,
                'totalUsers' => $totalUsers,
                'totalGuests' => $totalGuests,
                'totalReservations' => $totalReservations,
                'users' => $users,
                'reservationData' => $reservationData,
                'totalTransactions' => $totalTransactions,
                'totalPaidTransactions' => $totalPaidTransactions,
            ]);
        } else {
            return redirect()->route('staff.login');
        }
    }
    public function reservations()
    {
        $reservations = DB::table('reservation_details')
            ->leftJoin('accomodations', 'reservation_details.accomodation_id', '=', 'accomodations.accomodation_id')
            ->leftJoin('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
            ->select(
                'reservation_details.*',
                'accomodations.accomodation_name',
                'packagestbl.package_name',
                'packagestbl.package_activities',
                'packagestbl.package_room_type'
            )
            ->orderByDesc('reservation_details.created_at')
            ->paginate(10); // Get all reservations

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
            } elseif (is_numeric($activityIds)) { // Single integer case
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
            } elseif (is_numeric($accommodationIds)) { // Single integer case
                $reservation->accommodations = DB::table('accomodations')
                    ->where('accomodation_id', $accommodationIds)
                    ->pluck('accomodation_name')
                    ->toArray();
            }
        }

        // Debugging: Log the fetched details
        \Log::info('All Reservations:', ['reservations' => $reservations]);

        return view('StaffSide.StaffReservation', compact('reservations'));
    }


    public function accomodations()
    {
            // Fetch all accommodations
                $accomodations = DB::table('accomodations')->get();
                // Compute Room Overview
                $totalRooms = DB::table('accomodations')->count();
                $vacantRooms = DB::table('accomodations')->where('accomodation_status', 'available')->count();

                // Adjust reservedRooms count and update available slots
                $reservedRooms = DB::table('reservation_details')
                    ->whereIn('payment_status', ['booked', 'paid'])
                    ->count();
        return view('StaffSide.StaffsideAccomodations', compact('accomodations', 'totalRooms', 'vacantRooms', 'reservedRooms'));
    }

    
    public function editRoom(Request $request, $accomodation_id)
    {
        $request->validate([
            'accomodation_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'accomodation_name' => 'required|string|max:255',
            'accomodation_type' => 'required|in:room,cottage',
            'accomodation_capacity' => 'required|numeric|min:1',
            'accomodation_price' => 'required|numeric|min:0',
            'accomodation_status' => 'required|in:available,unavailable,maintenance',
            'accomodation_slot' => 'required|numeric|min:1',
            'accomodation_price' => 'required|numeric|min:0',
            'accomodation_description' => 'nullable|string',
        ]);

        // Find accommodation using Eloquent
        $accomodation = Accomodation::find($accomodation_id);
        if (!$accomodation) {
            return redirect()->back()->with('error', 'Accommodation not found.');
        }

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
        $accomodation->accomodation_slot = $request->accomodation_slot;
        $accomodation->accomodation_description = $request->accomodation_description;
        $accomodation->save();

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
                'payment_status' => 'booked,paid',
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
        $reservation = DB::table('reservation_details')->where('id', $reservationId)->first();

        if ($reservation && in_array($reservation->payment_status, ['cancelled', 'checked_out']) && in_array($reservation->reservation_status, ['Checked-out', 'Cancelled'])) {
            $roomIds = json_decode($reservation->accomodation_id, true);

            // Increase slots for each room booked
            DB::table('accomodations')
                ->whereIn('accomodation_id', $roomIds)
                ->increment('available_slots');

            // Delete reservation
            DB::table('reservation_details')->where('id', $reservationId)->delete();

            return response()->json(['success' => true, 'message' => 'Reservation canceled, slot restored.']);
        }

        return response()->json(['success' => false, 'message' => 'Reservation not found or not eligible for cancellation.']);
    }

    public function UpdateStatus(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'payment_status' => 'required|string',
            'custom_message' => 'nullable|max:255',
            'reservation_status' => 'required|in:Upcoming,Checked-in,Checked-out,Cancelled',
        ]);

        // Update payment status and reservation status
        DB::table('reservation_details')->where('id', $id)->update([
            'payment_status' => $request->payment_status,
            'reservation_status' => $request->reservation_status,
            'custom_message' => $request->custom_message ?? null,
        ]);

        // Send email with reservation details
        $reservation = Reservation::findOrFail($id);
        Mail::to($reservation->email)->send(new ReservationStatusUpdated($reservation, $request->custom_message, $reservation));

        return redirect()->route('staff.reservation')->with('success', 'Payment and reservation status updated successfully!');
    }

    

    public function checkNewReservations()
    {
        $newReservations = Reservation::whereBetween('created_at', [now()->subMinutes(5), now()])->count();

        return response()->json([
            'new_reservations' => $newReservations
        ]);
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