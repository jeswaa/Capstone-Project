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
            ->select('reservation_details.*', 'accomodations.accomodation_name', 'accomodations.accomodation_image', 'packagestbl.package_name')
            ->paginate(10);

        return view('StaffSide.StaffReservation', compact('reservations'));
    }

    public function accomodations()
    {
        $accomodations = DB::table('accomodations')->get();
        return view('StaffSide.StaffsideAccomodations', compact('accomodations'));
    }

    
    public function addRoom(Request $request)
    {
        $request->validate([
            'accomodation_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'accomodation_name' => 'required|string|max:255',
            'accomodation_type' => 'required|in:room,cottage',
            'accomodation_capacity' => 'required|numeric|min:1',
            'accomodation_price' => 'required|numeric|min:0',
            'accomodation_status' => 'required|in:available,unavailable,maintenance',
            'accomodation_slot' => 'required|numeric|min:1',
        ]);

        // Store the image
        $imagePath = $request->file('accomodation_image')->store('public/accomodations');

        // Create the new accommodation
        $accomodation = Accomodation::create([
            'accomodation_image' => str_replace('public/', '', $imagePath),
            'accomodation_name' => $request->input('accomodation_name'),
            'accomodation_type' => $request->input('accomodation_type'),
            'accomodation_capacity' => $request->input('accomodation_capacity'),
            'accomodation_price' => $request->input('accomodation_price'),
            'accomodation_status' => $request->input('accomodation_status'),
            'accomodation_slot' => $request->input('accomodation_slot'),
        ]);

        return redirect()->route('staff.accomodations')->with('success', 'Room added successfully!');
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
        $accomodation->save();

        return redirect()->route('staff.accomodations')->with('success', 'Rooms updated successfully!');
    }

    public function UpdateStatus(Request $request, $id)
{
    // Validate the input
    $request->validate([
        'payment_status' => 'required|string',
        'custom_message' => 'nullable|max:255',
        'reservation_status' => 'required|in:Upcoming,Checked-in,Checked-out,Cancelled',
    ]);

    // Find the reservation
    $reservation = Reservation::findOrFail($id);

    // Update payment status
    $reservation->payment_status = $request->payment_status;

    // Update reservation status
    $reservation->reservation_status = $request->reservation_status;

    // Update custom message if present
    if (!empty($request->custom_message)) {
        $reservation->custom_message = $request->custom_message;
    }

    // Force save even if Laravel doesn't detect a change
    $reservation->setAttribute('updated_at', now());
    $reservation->save();

    // Send email with reservation details
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
            $reservationDetails = Reservation::find($request->reservation_id);
        }

        // Send email with reservation details
        Mail::to($request->email)->send(new SendEmail($request->subject, $request->message, $reservationDetails));

        return redirect()->route('staff.reservation')->with('success', 'Email sent successfully!');
    }
}
