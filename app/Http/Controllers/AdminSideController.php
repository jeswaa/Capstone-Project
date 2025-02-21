<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('AdminSide.guest');
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

    public function DashboardView(){
        $adminCredentials = DB::table('admintbl')->first();

        if (!$adminCredentials) {
            abort(404, 'Admin credentials not found'); // To handle empty response
        }

        $users = DB::table('users')->get();
        $totalUsers = $users->count();
        $totalGuests = DB::table('users')->count();
        $totalReservations = DB::table('reservation_details')->count();

        return view('Adminside.dashboard', [
            'adminCredentials' => $adminCredentials,
            'totalUsers' => $totalUsers,
            'totalGuests' => $totalGuests,
            'totalReservations' => $totalReservations,
            'users' => $users
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
            'accomodation_image' => 'required|image|mimes:jpeg,png,jpg,gif',
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

        DB::table('accomodations')->insert([
            'accomodation_image' => $request->accomodation_image,
            'accomodation_name' => $request->accomodation_name,
            'accomodation_type' => $request->accomodation_type,
            'accomodation_capacity' => $request->accomodation_capacity,
            'accomodation_price' => $request->accomodation_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('rooms')->with('success', 'Accomodation added successfully!');
    }

    public function DisplayAccomodations()
    {
        $accomodations = DB::table('accomodations')->get();
        
        return view('AdminSide.addRoom', ['accomodations' => $accomodations]);
    }

}
