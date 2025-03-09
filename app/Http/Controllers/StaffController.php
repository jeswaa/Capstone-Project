<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $reservations = DB::table('reservation_details')->orderBy('created_at', 'desc')->paginate(10);
        return view('StaffSide.StaffReservation', compact('reservations'));  
    }

    public function transactions()
    {
        $reservations = DB::table('reservation_details')->orderByDesc('created_at')->get();
        return view('Staffside.StaffTransaction', compact('reservations'));
    }
    public function UpdateStatus(Request $request, $id)
    {
        
        $request->validate([
            'payment_status' => 'required|string',
            'custom_message' => 'required|string|max:255'
        ]);

        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->payment_status = $request->payment_status;
            $reservation->save();

            Mail::to($reservation->email)->send(new ReservationStatusUpdated($reservation, $request->custom_message));

            return redirect()->route('staff.transactions')->with('success', 'Payment status updated successfully!');
        }

        return redirect()->route('staff.transactions')->with('error', 'Reservation not found.');
    }

}
