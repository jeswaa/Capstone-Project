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

    public function reports()
    {
        $totalReservations = DB::table('reservation_details')->count();
        $totalCancelled = DB::table('reservation_details')->where('payment_status', 'cancelled')->count();
        $totalConfirmed = DB::table('reservation_details')->where('payment_status', 'paid')->count();
        $totalPending = DB::table('reservation_details')->where('payment_status', 'pending')->count();

        // Time-based Reservation Counts
        $dailyReservations = DB::table('reservation_details')
        ->whereDate('created_at', Carbon::today())
        ->count();

        $weeklyReservations = DB::table('reservation_details')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $monthlyReservations = DB::table('reservation_details')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $yearlyReservations = DB::table('reservation_details')
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        // Most booked package
        $mostBooked = DB::table('reservation_details')
            ->join('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
            ->select('packagestbl.package_room_type', DB::raw('COUNT(*) as count'))
            ->groupBy('packagestbl.package_room_type')
            ->orderByDesc('count')
            ->first();

        return view('AdminSide.reports', compact(
            'totalReservations', 'totalCancelled', 'totalConfirmed', 'totalPending',
            'dailyReservations', 'weeklyReservations', 'monthlyReservations', 'yearlyReservations',
            'mostBooked'
        ));
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
    
        // Define selected year
        $selectedYear = request()->query('year') ?? date('Y');
    
        // Fetch User & Reservation Counts
        $totalUsers = DB::table('users')->count();
        $latestUser = DB::table('users')->latest()->first();
        $totalReservations = DB::table('reservation_details')->count();
        
        $today = Carbon::today();
    
        // Booking statistics
        $dailyBookings = DB::table('reservation_details')->whereDate('reservation_check_in_date', Carbon::today())->pluck('reservation_check_in_date');
        $weeklyBookings = DB::table('reservation_details')->whereBetween('reservation_check_in_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->pluck('reservation_check_in_date');
        $monthlyBookings = DB::table('reservation_details')->whereBetween('reservation_check_in_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->pluck('reservation_check_in_date');
        $yearlyBookings = DB::table('reservation_details')->whereYear('reservation_check_in_date', $selectedYear)->pluck('reservation_check_in_date');
    
        // Monthly bookings with grouping
        $monthlyBookingsData = DB::table('reservation_details')
            ->selectRaw('count(*) as count, MONTHNAME(reservation_check_in_date) as month')
            ->whereYear('reservation_check_in_date', $selectedYear) // Make sure this uses the variable
            ->groupBy('month')
            ->orderByRaw('MONTH(reservation_check_in_date)')
            ->get();
    
        $availableYears = DB::table('reservation_details')
            ->selectRaw('distinct YEAR(created_at) as year')
            ->orderBy('year')
            ->pluck('year')
            ->toArray();
    
        // Users Created Today
        $latestUserDaysAgo = DB::table('users')->whereDate('created_at', Carbon::today())->count();
    
        // Payment-related statistics
        $reservationStats = DB::table('reservation_details')
            ->selectRaw("
                SUM(payment_status = 'Paid') as totalTransactions,
                SUM(payment_status = 'booked') as bookedReservations,
                SUM(payment_status = 'pending') as pendingReservations,
                SUM(payment_status = 'cancelled') as cancelledReservations
            ")
            ->first();
        // Total Revenue (Paid Reservations)
        $totalRevenue = DB::table('reservation_details')
        ->where('payment_status', 'Paid')
        ->sum('amount');

        // Monthly Revenue Data
        $monthlyRevenueData = DB::table('reservation_details')
    ->selectRaw('COALESCE(SUM(amount), 0) as revenue, MONTH(created_at) as month_number')
    ->whereYear('created_at', $selectedYear) // Use 'created_at' for consistency
    ->whereIn('payment_status', ['Paid', 'booked', 'pending', 'cancelled'])
    ->groupBy('month_number')
    ->orderBy('month_number')
    ->get();

// Ensure all 12 months exist in the result
$allMonths = collect(range(1, 12))->map(function ($month) use ($monthlyRevenueData) {
    return [
        'month_number' => $month,
        'revenue' => $monthlyRevenueData->firstWhere('month_number', $month)->revenue ?? 0
    ];
});



    
        // Latest Reservations with Joins
        $latestReservations = DB::table('reservation_details')
            ->join('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
            ->leftJoin('accomodations', 'reservation_details.accomodation_id', '=', 'accomodations.accomodation_id')
            ->leftJoin('activitiestbl', 'reservation_details.activity_id', '=', 'activitiestbl.id')
            ->orderByDesc('reservation_details.created_at')
            ->limit(1)
            ->select([
                'reservation_details.*',
                'packagestbl.package_room_type',
                'packagestbl.package_max_guests',
                'accomodations.accomodation_name',
                'activitiestbl.activity_name'
            ])
            ->get();
    
        return view('Adminside.dashboard', [
            'adminCredentials' => $adminCredentials,
            'totalRevenue' => $totalRevenue,
            'monthlyRevenueData' => $monthlyRevenueData,
            'totalUsers' => $totalUsers,
            'latestUser' => $latestUser,
            'totalReservations' => $totalReservations,
            'dailyBookings' => $dailyBookings,
            'weeklyBookings' => $weeklyBookings,
            'monthlyBookings' => $monthlyBookings,
            'monthlyBookingsData' => $monthlyBookingsData,
            'yearlyBookings' => $yearlyBookings,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear, // This is correctly passed
            'latestUserDaysAgo' => $latestUserDaysAgo,
            'totalTransactions' => $reservationStats->totalTransactions ?? 0,
            'bookedReservations' => $reservationStats->bookedReservations ?? 0,
            'pendingReservations' => $reservationStats->pendingReservations ?? 0,
            'cancelledReservations' => $reservationStats->cancelledReservations ?? 0,
            'latestReservations' => $latestReservations,
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
        $packages = DB::table('packagestbl')
            ->leftJoin('accomodations', 'packagestbl.package_room_type', '=', 'accomodations.accomodation_id')
            ->select('packagestbl.*', 'accomodations.accomodation_name')
            ->get();
        $accomodations = DB::table('accomodations')->get();
        return view('AdminSide.packages', [
            'packages' => $packages,
            'accomodations' => $accomodations
        ]);
    }

    public function addRoom(Request $request)
    {
        
        $request->validate([
            'accomodation_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'accomodation_name' => 'required|string|max:255',
            'accomodation_type' => 'required|in:room,cottage',  
            'accomodation_capacity' => 'required|numeric|min:1',
            'accomodation_price' => 'required|numeric|min:0',
            'accomodation_status' => 'required|in:available,unavailable',
            'room_id' => 'required|numeric',
            'accomodation_description' => 'nullable|string'
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
            'accomodation_status' => $request->accomodation_status,
            'room_id' => $request->room_id,
            'accomodation_description' => $request->accomodation_description,
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
            'accomodation_status' => 'required|in:available,unavailable',
            'room_id' => 'required|numeric',
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
        $accomodation->room_id = $request->room_id;
        $accomodation->accomodation_description = $request->accomodation_description;
        $accomodation->save();

        return redirect()->route('rooms')->with('success', 'Accommodation updated successfully!');
    }

    public function deleteRoom($accomodation_id)
    {
        // Find accommodation using Eloquent
        $accomodation = Accomodation::find($accomodation_id);

        if (!$accomodation) {
            return redirect()->route('rooms')->with('error', 'Accommodation not found.');
        }

        // Delete the image if it exists
        if ($accomodation->accomodation_image) {
            Storage::delete('public/' . $accomodation->accomodation_image);
        }

        // Delete the accommodation from the database
        $accomodation->delete();

        return redirect()->route('rooms')->with('success', 'Accommodation deleted successfully!');
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
        // Get all accommodations
        $accomodations = DB::table('accomodations')->orderByDesc('created_at')->get();

        // Get total accommodation count
        $count = count($accomodations);

        // Get total available slots (only for accommodations marked as 'available')
        $countAvailableRoom = DB::table('accomodations')
            ->where('accomodation_status', 'available')
            ->sum('accomodation_slot');

        $countReservedRoom = DB::table('reservation_details')
        ->where('payment_status', 'booked') // ✅ Get only booked reservations
        ->count();
    
            

        // Merge accommodations with available slots calculation
        foreach ($accomodations as $accomodation) {
            $reservedCount = $countReservedRoom[$accomodation->accomodation_id] ?? 0;
            $accomodation->available_slots = max($accomodation->accomodation_slot - $reservedCount, 0);
        }

        return view('AdminSide.addRoom', [
            'accomodations' => $accomodations,
            'count' => $count,
            'countAvailableRoom' => $countAvailableRoom,
            'countReservedRoom' => $countReservedRoom,
        ]);
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
