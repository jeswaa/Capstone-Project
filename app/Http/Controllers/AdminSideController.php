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

    // Simulan ang query para sa reservations
    $query = DB::table('reservation_details')
        ->leftJoin('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')  // Join the packages table
        ->orderByDesc('reservation_details.created_at');

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

    // Paginate the results
    $reservations = $query->select('reservation_details.*', 'packagestbl.package_room_type')  // Select room type from packages
        ->paginate(10);

    // Decode the JSON room type IDs and fetch room names
    foreach ($reservations as $reservation) {
        if (!empty($reservation->package_room_type)) { // ✅ Ensure it's not empty
            $roomTypeIds = json_decode($reservation->package_room_type, true);

            if (is_array($roomTypeIds) && count($roomTypeIds) > 0) { // ✅ Ensure it's a valid array
                // Fetch accommodation names based on IDs
                $roomNames = DB::table('accomodations')
                    ->whereIn('accomodation_id', $roomTypeIds)
                    ->pluck('accomodation_name')
                    ->toArray();

                // Store room names in the reservation object
                if (!empty($roomNames)) {
                    $reservation->room_types = implode(', ', $roomNames);
                }
            }
        } else {
            $reservation->room_types = "N/A"; // ✅ Default value if empty
        }
    }

    // Fetch calendar data
    $events = [];
    foreach ($reservations as $reservation) {
        $events[] = [
            'title' => 'Reservation',
            'start' => $reservation->reservation_check_in_date,
            'end' => $reservation->reservation_check_out_date,
            'description' => 'Reserved Room: ' . $reservation->room_types,
        ];
    }

    // Return view with data
    return view('AdminSide.reservation', compact('reservations', 'users', 'noReservationMessage', 'events'));
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
            ->selectRaw('count(*) as count, MONTH(reservation_check_in_date) as month_number, MONTHNAME(reservation_check_in_date) as month_name')
            ->whereYear('reservation_check_in_date', $selectedYear)
            ->groupBy('month_number', 'month_name')
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
        ->whereIn('payment_status', ['Paid', 'booked'])
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->selectRaw('MONTH(reservation_check_in_date) as month_number, MONTHNAME(reservation_check_in_date) as month_name, SUM(CAST(REPLACE(REPLACE(SUBSTRING(amount, 3), \',\', \'\'), \'₱\', \'\') AS DECIMAL(10, 2))) as total_revenue')
        ->groupBy('month_number', 'month_name')
        ->orderByRaw('CAST(month_number AS UNSIGNED)')
        ->get();
    
        // Create an array of months
        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June', 
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
    
        // Fill missing months with 0 revenue
        $revenueData = array_map(function($month) use ($monthlyRevenueData) {
            $data = $monthlyRevenueData->firstWhere('month_name', $month);
            return [
                'month_name' => $month,
                'total_revenue' => $data ? $data->total_revenue : 0
            ];
        }, $allMonths);
    
        // Fetch latest reservations with package details
        $latestReservations = DB::table('reservation_details')
            ->join('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
            ->leftJoin('accomodations', 'reservation_details.accomodation_id', '=', 'accomodations.accomodation_id')
            ->leftJoin('activitiestbl', 'reservation_details.activity_id', '=', 'activitiestbl.id')
            ->orderByDesc('reservation_details.created_at')
            ->limit(1) // Fetch more than 1 for better testing
            ->select([
                'reservation_details.*',
                'packagestbl.package_room_type', // Fetch raw JSON of room IDs
                'packagestbl.package_max_guests',
                'accomodations.accomodation_name as individual_accomodation',
                'activitiestbl.activity_name'
            ])
            ->get();
    
        // Process and decode room types (from package_room_type)
        foreach ($latestReservations as $reservation) {
            if (!empty($reservation->package_room_type)) {
                $roomTypeIds = json_decode($reservation->package_room_type, true); // Decode JSON array
        
                if (is_array($roomTypeIds) && count($roomTypeIds) > 0) { // Ensure valid array
                    // Fetch accommodation names from IDs
                    $roomNames = DB::table('accomodations')
                        ->whereIn('accomodation_id', $roomTypeIds)
                        ->pluck('accomodation_name')
                        ->toArray();
        
                    // Store formatted names in the reservation object
                    $reservation->room_types = !empty($roomNames) ? implode(', ', $roomNames) : "N/A";
                } else {
                    $reservation->room_types = "N/A";
                }
            } else {
                $reservation->room_types = "N/A";
            }
        }
    
        return view('Adminside.dashboard', [
            'adminCredentials' => $adminCredentials,
            'revenueData' => $revenueData,
            'totalRevenue' => $totalRevenue, 
            'totalUsers' => $totalUsers,
            'latestUser' => $latestUser,
            'totalReservations' => $totalReservations,
            'dailyBookings' => $dailyBookings,
            'weeklyBookings' => $weeklyBookings,
            'monthlyBookings' => $monthlyBookings,
            'monthlyBookingsData' => $monthlyBookingsData,
            'yearlyBookings' => $yearlyBookings,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
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
        // Get the entrance fee
        $entranceFee = Transaction::first()->entrance_fee;

        // Get today's date
        $today = Carbon::today();

        // Calculate today's total revenue
        $totalTodayRevenue = DB::table('reservation_details')
            ->where('payment_status', 'Paid')
            ->whereDate('reservation_check_in_date', $today)
            ->selectRaw("SUM(CAST(REPLACE(REPLACE(amount, '₱', ''), ',', '') AS DECIMAL(10, 2))) as total_revenue")
            ->first();
        $dailyRevenue = $totalTodayRevenue ? $totalTodayRevenue->total_revenue : 0;

        // Calculate this week's total revenue
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $totalWeeklyRevenue = DB::table('reservation_details')
            ->whereBetween('reservation_check_in_date', [$startOfWeek, $endOfWeek])
            ->selectRaw("SUM(CAST(REPLACE(REPLACE(amount, '₱', ''), ',', '') AS DECIMAL(10, 2))) as total_revenue")
            ->first();
        $weeklyRevenue = $totalWeeklyRevenue ? $totalWeeklyRevenue->total_revenue : 0;

        // Calculate this month's total revenue
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $totalMonthlyRevenue = DB::table('reservation_details')
            ->whereBetween('reservation_check_in_date', [$startOfMonth, $endOfMonth])
            ->selectRaw("SUM(CAST(REPLACE(REPLACE(amount, '₱', ''), ',', '') AS DECIMAL(10, 2))) as total_revenue")
            ->first();
        $monthlyRevenue = $totalMonthlyRevenue ? $totalMonthlyRevenue->total_revenue : 0;

        // Get all pending payments
        $totalPendingPayment = DB::table('reservation_details')
            ->where('payment_status', 'pending')
            ->get();
          
        // Pass the data to the view
        return view('AdminSide.Transactions', [
            'entranceFee' => number_format($entranceFee, 2),
            'dailyRevenue' => $dailyRevenue,
            'weeklyRevenue' => $weeklyRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'totalPendingPayment' => $totalPendingPayment,
        ]);
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
        'package_room_type' => 'nullable|array', // ✅ Change from string to array
        'package_activities' => 'nullable|string',
    ]);

    // ✅ Handle file upload properly
    if ($request->hasFile('image_package')) {
        try {
            $imagePath = $request->file('image_package')->store('package_images', 'public');
        } catch (\Exception $e) {
            return back()->withErrors(['image_package' => 'Error saving image. Please try again.']);
        }
    } else {
        $imagePath = null;
    }

    // ✅ Convert multiple room types to JSON before storing
    $packageRoomTypes = $request->package_room_type ? json_encode($request->package_room_type) : null;

    DB::table('packagestbl')->insert([
        'image_package' => $imagePath,
        'package_name' => $request->package_name,
        'package_description' => $request->package_description,
        'package_room_type' => $packageRoomTypes, // ✅ Store as JSON
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
    $accomodations = DB::table('accomodations')->get();

    foreach ($packages as $package) {
        // Decode the JSON room type IDs
        $roomTypeIds = json_decode($package->package_room_type, true);

        // Initialize room_types property
        $package->room_types = 'No rooms assigned';

        if (!empty($roomTypeIds)) {
            // Fetch accommodation names based on IDs
            $roomNames = DB::table('accomodations')
                ->whereIn('accomodation_id', $roomTypeIds)
                ->pluck('accomodation_name')
                ->toArray();

            // Store room names in the package object
            if (!empty($roomNames)) {
                $package->room_types = implode(', ', $roomNames);
            }
        }
    }

    return view('AdminSide.packages', compact('packages', 'accomodations'));
}

    public function addRoom(Request $request)
    {
        $request->validate([
            'accomodation_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'accomodation_name' => 'required|string|max:255',
            'accomodation_type' => 'required|in:room,cottage,cabin',
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

        // Ensure the accomodation_type value is a valid string
        $accomodationType = in_array($request->accomodation_type, ['room', 'cottage', 'cabin']) 
                            ? $request->accomodation_type 
                            : null;

        if (!$accomodationType) {
            return redirect()->back()->with('error', 'Invalid accommodation type. Please select a valid type.');
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
            ->count();

        $countReservedRoom = DB::table('reservation_details')
        ->where('payment_status', 'booked') // ✅ Get only booked reservations
        ->count();
    
            

        // Merge accommodations with available slots calculation
        foreach ($accomodations as $accomodation) {
            $accomodation->available_rooms = $accomodation->accomodation_status == 'available' ? 1 : 0;
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

    public function addOns()
    {
        $addons = DB::table('addons')->get();
        return view('AdminSide.addOns', ['addons' => $addons]);
    }

    public function storeAddOns(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Attempt to store the image
        $imagePath = $request->file('image')->store('add_ons', 'public');

        // Check if the image was successfully saved
        if (!$imagePath) {
            return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
        }

        // Use the DB facade to create a new add on
        DB::table('addons')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('addOns')->with('success', 'Add on added successfully!');
    }

    public function editAddOn(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Find the add-on record
        $addon = DB::table('addons')->where('id', $id)->first();
        if (!$addon) {
            return redirect()->route('addOns')->with('error', 'Add-on not found.');
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($addon->image) {
                Storage::delete('public/' . $addon->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('add_ons', 'public');
        } else {
            // Keep the existing image
            $imagePath = $addon->image;
        }

        // Update the add-on details
        DB::table('addons')->where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('addOns')->with('success', 'Add-on updated successfully!');
    }

    
    public function deleteAddOn($id)
    {
        // Find the add-on record
        $addon = DB::table('addons')->where('id', $id)->first();
        if (!$addon) {
            return redirect()->route('addOns')->with('error', 'Add-on not found.');
        }

        // Delete the image if it exists
        if ($addon->image) {
            Storage::delete('public/' . $addon->image);
        }

        // Delete the add-on record
        DB::table('addons')->where('id', $id)->delete();

        return redirect()->route('addOns')->with('success', 'Add-on deleted successfully!');
    }


}
