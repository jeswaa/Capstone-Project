<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        return redirect()->route('StaffLogin')->with('success', 'Logged out successfully!');
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

            return view('StaffSide.StaffDashboard', [
                'staffCredentials' => $staffCredentials,
                'totalUsers' => $totalUsers,
                'totalGuests' => $totalGuests,
                'totalReservations' => $totalReservations,
                'users' => $users
            ]);
        } else {
            return redirect()->route('staff.login');
        }
    }
    public function reservations()
    {
        $reservations = DB::table('reservation_details')->orderBy('created_at', 'desc')->paginate(10);
        return view('StaffSide.StaffReservation', compact('reservations'));  
    }

    public function transactions()
    {
        $reservations = DB::table('reservation_details')->orderByDesc('created_at')->paginate(10);
        $amounts = DB::table('reservation_details')->pluck('amount', 'id');
        $pending = DB::table('reservation_details')->where('payment_status', 'pending')->paginate(10);
        $paid = DB::table('reservation_details')->where('payment_status', 'paid')->paginate(10);
        $booked = DB::table('reservation_details')->where('payment_status', 'booked')->paginate(10);
        $cancelled = DB::table('reservation_details')->where('payment_status', 'cancelled')->paginate(10);
        return view('Staffside.StaffTransaction', compact('reservations', 'pending', 'paid', 'booked', 'cancelled', 'amounts'));
    }
    public function UpdateStatus(Request $request, $id)
{
    $request->validate([
        'payment_status' => 'required|string',
        'custom_message' => 'nullable|max:255'
    ]);

    $reservation = Reservation::find($id);

    if ($reservation) {
        // Update payment status
        $reservation->payment_status = $request->payment_status;
        
        // I-update lang ang custom_message kung may laman
        if (!empty($request->custom_message)) {
            $reservation->custom_message = $request->custom_message;
        }

        // **Force save even if Laravel doesn't detect a change**
        $reservation->setAttribute('updated_at', now());
        $reservation->save();

        Mail::to($reservation->email)->send(new ReservationStatusUpdated($reservation, $request->custom_message));

        return redirect()->route('staff.transactions')->with('success', 'Payment status updated successfully!');
    }

    return redirect()->route('staff.transactions')->with('error', 'Reservation not found.');
}

    public function updateReservationStatus(Request $request, $id)
    {
        
        // Validate the input
        $request->validate([
            'reservation_status' => 'required|in:Upcoming,Checked-in,Checked-out,Cancelled',
        ]);

        // Find the reservation
        $reservation = Reservation::findOrFail($id);

        // Update the status
        $reservation->reservation_status = $request->reservation_status;
        $reservation->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Reservation status updated successfully!');
    }


}
