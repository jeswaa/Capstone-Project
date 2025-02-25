<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class AdminSideController extends Controller
{
    public function dashboard(){
        return view('AdminSide.dashboard');
    }

    public function reservations(){
        return view('AdminSide.reservation');
    }

    public function roomAvailability(){
        return view('AdminSide.roomAvailability');
    }
    public function Room()
    {
        return view('AdminSide.addRoom');
    }

    public function guests(){
        $upcomingReservations = DB::table('reservation_details')
            ->whereDate('reservation_date', '>', Carbon::today()->endOfDay())
            ->count();
        $users = DB::table('users')->count();
        $reservations = DB::table('reservation_details')->get();
        $totalGuests = DB::table('users')->count();
        $totalReservations = DB::table('reservation_details')->count();
        return view('AdminSide.guest', ['users' => $users, 'reservations' => $reservations, 'totalGuests' => $totalGuests, 'totalReservations' => $totalReservations, 'upcomingReservations' => $upcomingReservations]);
    }

    public function transactions(){
        return view('AdminSide.transactions');
    }

    public function reports(){
        return view('AdminSide.reports');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('AdminLogin')->with('success', 'Logged out successfully!');
    }

    //Login Function
    public function AdminLogin(){
        return view('AdminSide.adminLogin');
    }

    public function login(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');

        $admin = \App\Models\Admin::where('username', $username)->first();

        if ($admin && $admin->password == $password) {
            session()->put('AdminLogin', $admin->id);
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function DashboardView() {
        $adminCredentials = DB::table('admintbl')->first();
    
        if (!$adminCredentials) {
            abort(404, 'Admin credentials not found');
        }
    
        $users = DB::table('users')->get();
        $totalUsers = $users->count();
        $latestUser = DB::table('users')->latest()->first();
        $totalGuests = DB::table('users')->count();
        $totalReservations = DB::table('reservation_details')->count();
    
        // Fetch Booking Statistics for Daily, Weekly, and Monthly
        $today = Carbon::today();
    
        // Daily bookings
        $dailyBookings = DB::table('reservation_details')
            ->whereDate('created_at', $today)
            ->count();
    
        // Weekly bookings
        $startOfWeek = Carbon::now()->startOfWeek();
        $weeklyBookings = DB::table('reservation_details')
            ->whereBetween('created_at', [$startOfWeek, $today])
            ->count();
    
        // Monthly bookings
        $startOfMonth = Carbon::now()->startOfMonth();
        $monthlyBookings = DB::table('reservation_details')
            ->whereBetween('created_at', [$startOfMonth, $today])
            ->count();
    
        // Calculate the number of users created today
        $latestUserDaysAgo = DB::table('users')
            ->whereDate('created_at', Carbon::today())
            ->count();
    
        return view('Adminside.dashboard', [
            'adminCredentials' => $adminCredentials,
            'totalUsers' => $totalUsers,
            'latestUser' => $latestUser,
            'totalGuests' => $totalGuests,
            'totalReservations' => $totalReservations,
            'users' => $users,
            'dailyBookings' => $dailyBookings,
            'weeklyBookings' => $weeklyBookings,
            'monthlyBookings' => $monthlyBookings,
            'latestUserDaysAgo' => $latestUserDaysAgo // Add this line
        ]);
    }
    
    public function editPrice()
    {
        $entranceFee = Transaction::first()->entrance_fee;
       
        return view('AdminSide.transactions', ['entranceFee' => number_format($entranceFee, 2)]);
    }

    public function updatePrice(Request $request)
    {
        $request->validate(['entrance_fee' => 'required']);
        
        Transaction::first()->update(['entrance_fee' => $request->entrance_fee]);
        return redirect()->route('transactions')->with('success', 'Entrance fee updated successfully!');
    }

    public function addPackages(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'package_description' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
            'package_duration' => 'nullable|string',
            'package_max_guests' => 'nullable|string',
            'package_activities' => 'nullable|string',
        ]);

        DB::table('packagestbl')->insert([
            'package_name' => $request->package_name,
            'package_description' => $request->package_description,
            'package_price' => $request->package_price,
            'package_duration' => $request->package_duration,
            'package_max_guests' => $request->package_max_guests,
            'package_activities' => $request->package_activities,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('packages')->with('success', 'Package added successfully!');
    }

    public function packages()
    {
        $packages = DB::table('packagestbl')->get();
        return view('AdminSide.packages', ['packages' => $packages]);
    }

    public function addRoom(Request $request)
    {
        $request->validate([
            'accomodation_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'accomodation_name' => 'required|string|max:255',
            'accomodation_type' => 'required|in:room,cottage',  
            'accomodation_capacity' => 'required|numeric|min:1',
            'accomodation_price' => 'required|numeric|min:0',
        ]);
    
        // Handle file upload
        if ($request->hasFile('accomodation_image')) {
            $imagePath = $request->file('accomodation_image')->store('accomodations', 'public');
        } else {
            return back()->withErrors(['accomodation_image' => 'Failed to upload image.']);
        }
    
        // Insert into database with the correct image path
        DB::table('accomodations')->insert([
            'accomodation_image' => $imagePath,
            'accomodation_name' => $request->accomodation_name,
            'accomodation_type' => $request->accomodation_type,
            'accomodation_capacity' => $request->accomodation_capacity,
            'accomodation_price' => $request->accomodation_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('rooms')->with('success', 'Accommodation added successfully!');
    }


    public function DisplayAccomodations()
    {
        $accomodations = DB::table('accomodations')->orderByDesc('created_at')->get();
        
        return view('AdminSide.addRoom', ['accomodations' => $accomodations]);
    }

}
