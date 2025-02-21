<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationEmail;

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
        return view('StaffSide.StaffGuest');
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
        $reservations = DB::table('reservation_details')->get();
        return view('StaffSide.StaffReservation', compact('reservations'));

        
    }
    public function sendEmail(Request $request)
    {
        $email = $request->email_to;
        $subject = $request->email_subject;
        $message = $request->email_message;

        Mail::to($email)->send(new ReservationEmail($subject, $message));

        return back()->with('success', 'Email sent successfully!');
    }
    public function transactions()
    {
        $reservations = DB::table('reservation_details')->get();
        return view('Staffside.StaffTransaction', compact('reservations'));
    }
    public function UpdateStatus(Request $request, $id)
{
    // Validate the input to ensure payment_status is provided
    $request->validate([
        'payment_status' => 'required|string'
    ]);

    // Fetch the reservation with the given ID
    $reservation = Reservation::find($id);

    // Ensure the reservation exists before updating
    if ($reservation) {
        $reservation->payment_status = $request->payment_status;
        $reservation->save(); // Save the updated field

        return redirect()->route('staff.transactions')->with('success', 'Payment status updated successfully!');
    }

    // If reservation is not found, return with an error
    return redirect()->route('staff.transactions')->with('error', 'Reservation not found.');
}




}
