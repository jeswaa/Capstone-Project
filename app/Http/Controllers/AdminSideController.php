<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Accomodation;
use App\Models\Package;
use App\Models\Activities;

class AdminSideController extends Controller
{
    public function dashboard(){
        return view('AdminSide.dashboard');
    }

    public function reservations(Request $request) 
    {
        // Kunin lahat ng users para sa dropdown
        $users = DB::table('users')->get();

        $packages = DB::table('packagestbl')->get();
    
        // Simulan ang query para sa reservations
        $query = DB::table('reservation_details')->orderByDesc('created_at');
    
        // Variable para sa message kapag walang reservation ang user
        $noReservationMessage = null;
        
        // Check if a user is selected
        if ($request->has('user_id') && !empty($request->user_id)) {
            $filteredReservations = clone $query;
            $filteredReservations = $filteredReservations->where('reservation_details.user_id', $request->user_id);

            if ($filteredReservations->count() > 0) {
                $query = $filteredReservations;
            } else {
                // Show all reservations if the user has no reservations
                $noReservationMessage = "No reservation for this user. Displaying all reservations.";
            }
        }

        $reservations = $query->paginate(10);

        return view('AdminSide.reservation', compact('reservations', 'users', 'noReservationMessage'));
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
            ->whereDate('reservation_check_in_date', '>', Carbon::today()->endOfDay())
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
            'image_package' => 'required|image|mimes:jpeg,png,jpg,gif',
            'package_name' => 'required|string|max:255',
            'package_description' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
            'package_duration' => 'nullable|string',
            'package_max_guests' => 'nullable|string',
            'package_room_type' => 'nullable|string',
            'package_activities' => 'nullable|string',
        ]);

        if ($request->hasFile('image_package')) {
            try {
                $imagePath = $request->file('image_package')->store('package_images', 'public');
            } catch (\Exception $e) {
                return back()->withErrors(['image_package' => 'Error saving image. Please try again.']);
            }
        } else {
            $imagePath = null;
        }

        DB::table('packagestbl')->insert([
            'image_package' => $imagePath,
            'package_name' => $request->package_name,
            'package_description' => $request->package_description,
            'package_room_type' => $request->package_room_type,
            'package_price' => $request->package_price,
            'package_duration' => $request->package_duration,
            'package_max_guests' => $request->package_max_guests,
            'package_activities' => $request->package_activities,
        ]);

        return redirect()->route('packages')->with('success', 'Package added successfully!');
    }
    public function updatePackage(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'image_package' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'package_name' => 'required|string|max:255',
        'package_description' => 'nullable|string',
        'package_price' => 'required|numeric|min:0',
        'package_duration' => 'nullable|string',
        'package_max_guests' => 'nullable|integer|min:1',
        'package_activities' => 'nullable|string',
        'package_room_type' => 'nullable|string'
    ]);

    // Fetch the package from the database using Eloquent
    $package = Package::find($id);

    if (!$package) {
        return redirect()->back()->with('error', 'Package not found.');
    }

    // Handle image upload (if a new image is uploaded)
    if ($request->hasFile('image_package')) {
        // Delete old image if it exists
        if ($package->image_package && Storage::disk('public')->exists($package->image_package)) {
            Storage::disk('public')->delete($package->image_package);
        }
        
        // Store the new image
        $imagePath = $request->file('image_package')->store('package_images', 'public');
    } else {
        $imagePath = $package->image_package; // Keep old image if no new file uploaded
    }

    // Update the package in the database using Eloquent
    $package->update([
        'package_name' => $request->package_name,
        'package_description' => $request->package_description,
        'package_price' => $request->package_price,
        'package_duration' => $request->package_duration,
        'package_max_guests' => $request->package_max_guests,
        'package_activities' => $request->package_activities,
        'package_room_type' => $request->package_room_type,
        'image_package' => $imagePath, // Update image if changed
    ]);

    return redirect()->back()->with('success', 'Package updated successfully.');
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

        // Attempt to store the image
        $imagePath = $request->file('accomodation_image')->store('accomodations', 'public');

        // Check if the image was successfully saved
        if (!$imagePath) {
            return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
        }

        // Save the data into the database
        $inserted = DB::table('accomodations')->insert([
            'accomodation_image' => $imagePath, 
            'accomodation_name' => $request->accomodation_name,
            'accomodation_type' => $request->accomodation_type,
            'accomodation_capacity' => $request->accomodation_capacity,
            'accomodation_price' => $request->accomodation_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Check if database insert was successful
        if (!$inserted) {
            return redirect()->back()->with('error', 'Failed to save accommodation. Please try again.');
        }

        return redirect()->route('rooms')->with('success', 'Accommodation added successfully!');
    }


    public function updateRoom(Request $request, $accomodation_id)
    {
        $request->validate([
            'accomodation_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'accomodation_name' => 'required|string|max:255',
            'accomodation_type' => 'required|in:room,cottage',  
            'accomodation_capacity' => 'required|numeric|min:1',
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
        $accomodation->save();

        return redirect()->route('rooms')->with('success', 'Accommodation updated successfully!');
    }

    
    public function deletePackage($id)
    {
        // Attempt to delete the package from the database
        $deleted = DB::table('packagestbl')->where('id', $id)->delete();

        if ($deleted) {
            return redirect()->route('packages')->with('success', 'Package deleted successfully!');
        } else {
            return redirect()->route('packages')->with('error', 'Failed to delete package.');
        }
    }


    public function DisplayAccomodations()
    {
        $accomodations = DB::table('accomodations')->orderByDesc('created_at')->get();
        
        return view('AdminSide.addRoom', ['accomodations' => $accomodations]);
    }

    public function Activities()
    {
        $activities = DB::table('activitiestbl')->get();
        return view('AdminSide.Activities', ['activities' => $activities]);
    }

    public function storeActivity(Request $request)
    {
        // Validate the request
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_status' => 'required|string|max:255',
            'activity_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Attempt to store the image
        $imagePath = $request->file('activity_image')->store('activities', 'public');

        // Check if the image was successfully saved
        if (!$imagePath) {
            return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
        }

        // Use Eloquent to create a new activity
        Activities::create([
            'activity_name' => $request->activity_name,
            'activity_status' => $request->activity_status,
            'activity_image' => $imagePath,
        ]);

        return redirect()->route('addActivities')->with('success', 'Activity added successfully!');
    }

    
    public function updateActivity(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'activity_status' => 'required|string|max:255',
            'activity_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Attempt to store the image
        $imagePath = $request->file('activity_image')->store('activities', 'public');

        // Check if the image was successfully saved
        if ($imagePath) {
            // Delete the previous image
            $activity = Activities::find($id);
            Storage::delete($activity->activity_image);
        }

        // Use Eloquent to update the activity
        Activities::where('id', $id)->update([
            'activity_name' => $request->activity_name,
            'activity_status' => $request->activity_status,
            'activity_image' => $imagePath ?: $request->hidden_image,
        ]);

        return redirect()->route('addActivities')->with('success', 'Activity updated successfully!');
    }


}
