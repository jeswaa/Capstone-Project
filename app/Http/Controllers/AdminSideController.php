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
use DateTime;

class AdminSideController extends Controller
{
    public function dashboard(){
        return view('AdminSide.Dashboard');
    }

    public function reservations(Request $request) 
    {
        // Kunin lahat ng users para sa dropdown
        $users = DB::table('users')->get();
    
        // Simulan ang query para sa reservations
        $query = DB::table('reservation_details')
            ->leftJoin('users', 'reservation_details.user_id', '=', 'users.id')  // Join users
            ->select(
                'reservation_details.*',
                'users.name as user_name'
            )
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
        $reservations = $query->paginate(10);

    
        // Fetch accommodation names for each reservation
        foreach ($reservations as $reservation) {
            // Convert JSON or comma-separated IDs into an array
            $accomodationIds = json_decode($reservation->accomodation_id, true);
            
            if (!is_array($accomodationIds)) {
                $accomodationIds = explode(',', $reservation->accomodation_id); // If stored as comma-separated
            }
    
            // Fetch the names from the accommodations table
            $reservation->accomodation_names = DB::table('accomodations')
                ->whereIn('accomodation_id', $accomodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        }
    
        // Fetch calendar data
        $events = [];
        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => 'Reservation',
                'start' => $reservation->reservation_check_in_date,
                'end' => $reservation->reservation_check_out_date,
                'description' => 'Reserved Room: ' . implode(', ', $reservation->accomodation_names),
            ];
        }
    
        // Return view with data
        return view('AdminSide.Reservation', compact('reservations', 'users', 'noReservationMessage', 'events'));
    }

    public function roomAvailability(){
        return view('AdminSide.roomAvailability');
    }
    public function Room()
    {
        return view('AdminSide.addRoom');
    }

public function guests(){
    // Get upcoming reservations count
    $upcomingReservations = DB::table('reservation_details')
        ->whereDate('reservation_check_in_date', '>', Carbon::today()->endOfDay())
        ->count();
    
    // Get checked-in reservations count
    $checkedInReservations = DB::table('reservation_details')
        ->where('payment_status', 'checked-in')
        ->count();
        
    // Get user and reservation counts
    $users = DB::table('users')->count();
$reservations = DB::table('reservation_details')->paginate(10);
    $totalGuests = DB::table('users')->count();
    $totalReservations = DB::table('reservation_details')->count();

    // Get reserved count
    $reservedCount = DB::table('reservation_details')
        ->where('reservation_status', 'reserved')
        ->count();

    // Count cancelled reservations
    $cancelledReservations = DB::table('reservation_details')
        ->where(function($query) {
            $query->where('reservation_status', 'cancelled')
                  ->orWhere('payment_status', 'cancelled');
        })
        ->count();

    // Get upcoming reservations list with user details
    $upcomingReservationsList = DB::table('reservation_details')
        ->join('users', 'reservation_details.user_id', '=', 'users.id')
        ->select('reservation_details.*', 'users.name as guest_name')
        ->whereDate('reservation_check_in_date', '>', Carbon::today()->endOfDay())
        ->where('reservation_status', 'reserved')
        ->orderBy('reservation_check_in_date', 'asc')
        ->get();
        
    // Return view with all data
    return view('AdminSide.Guest', compact(
        'users',
        'reservations', 
        'totalGuests',
        'totalReservations',
        'upcomingReservations',
        'checkedInReservations',
        'upcomingReservationsList',
        'cancelledReservations'
    ));
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
        

        return view('AdminSide.Reports', compact(
            'totalReservations', 'totalCancelled', 'totalConfirmed', 'totalPending',
            'dailyReservations', 'weeklyReservations', 'monthlyReservations', 'yearlyReservations',
            'mostBooked'
        ));
    }

    
    public function logout(){
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function login(Request $request) {
        $credentials = $request->only('username', 'password');
        
        $admin = DB::table('admintbl')->where('username', $credentials['username'])->first();
        
        // Case 1: Passwords are plaintext (NOT recommended)
        if ($admin && $credentials['password'] === $admin->password) {
            session(['AdminLogin' => $admin->id]);
            return redirect()->route('dashboard');
        }
    
        // Case 2: Passwords use another algorithm (e.g., MD5)
        if ($admin && md5($credentials['password']) === $admin->password) {
            session(['AdminLogin' => $admin->id]);
            return redirect()->route('dashboard');
        }
        
        return back()->with('error', 'Invalid credentials');
    }
    

    public function DashboardView()
{
    $adminCredentials = DB::table('admintbl')->first();
    if (!$adminCredentials) {
        abort(404, 'Admin credentials not found');
    }

    // Total Bookings
    $totalBookings = DB::table('reservation_details')
        ->whereDate('created_at', Carbon::today())
        ->count();

    // Total Guests
    $totalGuests = DB::table('users')->count();

    // Get available years
    $availableYears = DB::table('reservation_details')
        ->select(DB::raw('YEAR(reservation_check_in_date) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Get selected year from request or use current year
    $selectedYear = request()->input('year', date('Y'));
    
    // Total Reservations - Daily (for selected year)
    $dailyReservations = DB::table('reservation_details')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->whereYear('created_at', $selectedYear)
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // Weekly Reservations (for selected year)
    $weeklyReservations = DB::table('reservation_details')
        ->select(DB::raw('YEARWEEK(created_at, 1) as week'), DB::raw('count(*) as total'))
        ->whereYear('created_at', $selectedYear)
        ->groupBy('week')
        ->orderBy('week', 'asc')
        ->get();

    // Monthly Reservations (for selected year)
    $monthlyReservations = DB::table('reservation_details')
        ->select(
            DB::raw('DATE_FORMAT(reservation_check_in_date, "%b %Y") as month'), 
            DB::raw('count(*) as total')
        )
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->groupBy('month')
        ->orderBy(DB::raw('MIN(reservation_check_in_date)'), 'asc')
        ->get();

    // Booking Trends - Last 12 months (regardless of year selection)
    $bookingTrends = DB::table('reservation_details')
        ->select(DB::raw("CONCAT(MONTHNAME(reservation_check_in_date), '-', YEAR(reservation_check_in_date)) as date"), DB::raw('count(*) as total'))
        ->where('created_at', '>=', Carbon::now()->subMonths(12))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // Reservation Status Breakdown
    $reservationStatusCounts = DB::table('reservation_details')
        ->select('payment_status', DB::raw('count(*) as total'))
        ->groupBy('payment_status')
        ->pluck('total', 'payment_status');

    // Paid Reservations
    $checkInReservations = DB::table('reservation_details')
        ->select([
            DB::raw('reservation_status'),
            DB::raw('count(*) as total')
        ])
        ->where('reservation_status', '=', 'checked-in')
        ->whereDate('created_at', '=', Carbon::today()->toDateString())
        ->groupBy('reservation_status')
        ->first();

    // Total Check-outs Today
    $checkOutReservations = DB::table('reservation_details')
        ->select(DB::raw('reservation_status'), DB::raw('count(*) as total'))
        ->where('reservation_status', 'checked-out')
        ->whereDate('updated_at', Carbon::today())
        ->groupBy('reservation_status')
        ->first();

    // Cancelled Reservations
    $cancelledReservations = DB::table('reservation_details')
        ->select(DB::raw('payment_status'), DB::raw('count(*) as total'))
        ->where('payment_status', 'cancelled')
        ->groupBy('payment_status')
        ->first();

    // Get total number of guests currently on-site
    $guestsOnSite = DB::table('reservation_details')
        ->select(DB::raw('count(*) as total'))
        ->where('reservation_status', 'checked-in')
        ->first();
    // Latest Reservation
    $latestReservations = DB::table('reservation_details')
        ->select('name', 'reservation_check_in_date', 'reservation_check_out_date', 'accomodation_id')
        ->where('payment_status', 'pending')
        ->orderBy('reservation_check_in_date', 'desc')
        ->limit(3)
        ->get();
    // Get total income for today
    $todayIncome = DB::table('reservation_details')
        ->whereDate('created_at', Carbon::today())
        ->whereIn('payment_status', ['paid', 'checked-in', 'checked-out'])
        ->sum(DB::raw('CAST(REPLACE(REPLACE(amount, "₱", ""), ",", "") AS DECIMAL(10,2))'));
    
    // Room Type Utilization
    $roomTypeUtilization = DB::table('reservation_details')
    ->select('accomodation_id')
    ->get()
    ->flatMap(function($reservation) {
        // Convert JSON or comma-separated IDs into an array
        $accomodationIds = json_decode($reservation->accomodation_id, true);
        
        if (!is_array($accomodationIds)) {
            $accomodationIds = explode(',', $reservation->accomodation_id); // If stored as comma-separated
        }

        return $accomodationIds;
    })
    ->map(function($id) {
        return DB::table('accomodations')
            ->select('accomodation_type')
            ->where('accomodation_id', $id)
            ->first();
    })
    ->groupBy('accomodation_type')
    ->map(function($group) {
        return count($group);
    });

    // Room Availability
    $roomAvailability = DB::table('reservation_details')
        ->select('reservation_check_in_date', 'reservation_check_out_date', 'accomodation_id')
        ->get()
        ->groupBy(function($reservation) {
            return (new DateTime($reservation->reservation_check_in_date))->format('Y-m-d');
        })
        ->map(function($reservations) {
            return $reservations->map(function($reservation) {
                // Decode accomodation_id
                $accomodationIds = json_decode($reservation->accomodation_id, true);
                if (!is_array($accomodationIds)) {
                    $accomodationIds = explode(',', $reservation->accomodation_id); // If stored as comma-separated
                }

                return DB::table('accomodations')
                    ->select('accomodation_type')
                    ->whereIn('accomodation_id', $accomodationIds)
                    ->first();
            })
            ->pluck('accomodation_type')
            ->unique()
            ->values()
            ->toArray();
        });
    // Calendar widget with color-coded availability
    $calendarData = [];
    $today = Carbon::today();
    
    // Get selected year from request or use current year
    $selectedYearCalendar = request()->input('year', date('Y'));
    
    // Set start and end dates for selected year
    $startDate = Carbon::createFromDate($selectedYearCalendar, 1, 1);
    $endDate = Carbon::createFromDate($selectedYearCalendar, 12, 31);

    // Get all reservations that overlap with the selected year
    $selectedReservations = DB::table('reservation_details')
        ->where(function($query) use ($startDate, $endDate) {
            $query->where(function($q) use ($startDate, $endDate) {
                $q->whereDate('reservation_check_in_date', '<=', $endDate)
                  ->whereDate('reservation_check_out_date', '>=', $startDate);
            });
        })
        ->get();

    // Get total number of rooms
    $totalRooms = DB::table('accomodations')->count();

    // Build calendar data for the entire year
    $currentDate = $startDate->copy();
    while ($currentDate <= $endDate) {
        $dateKey = $currentDate->format('Y-m-d');
        
        // Count bookings for this specific date
        $bookedRooms = $selectedReservations->filter(function($reservation) use ($currentDate) {
            $checkIn = Carbon::parse($reservation->reservation_check_in_date)->startOfDay();
            $checkOut = Carbon::parse($reservation->reservation_check_out_date)->endOfDay();
            return $currentDate->between($checkIn, $checkOut);
        })->count();

        // Determine availability status
        if ($bookedRooms == 0) {
            $status = 'available'; // ✅ Available
            $color = '#28a745';
        } elseif ($bookedRooms >= $totalRooms) {
            $status = 'booked'; // ❌ Fully Booked
            $color = '#dc3545';
        } else {
            $status = 'partial'; // 🟡 Partially Booked
            $color = '#ffc107';
        }

        $calendarData[] = [
            'date' => $dateKey,
            'status' => $status,
            'color' => $color,
            'available' => $totalRooms - $bookedRooms,
            'booked' => $bookedRooms
        ];

        $currentDate->addDay();
    }
    // Pass the data to the view
    return view('AdminSide.Dashboard', [
        'adminCredentials' => $adminCredentials,
        'totalBookings' => $totalBookings,
        'totalGuests' => $totalGuests,
        'dailyReservations' => $dailyReservations,
        'weeklyReservations' => $weeklyReservations,
        'monthlyReservations' => $monthlyReservations,
        'availableYears' => $availableYears,
        'selectedYear' => $selectedYear,
        'selectedYearCalendar' => $selectedYearCalendar,
        'selectedReservations' => $selectedReservations ,
        'bookingTrends' => $bookingTrends,
        'reservationStatusCounts' => $reservationStatusCounts,
        'checkInReservations' => $checkInReservations,
        'checkOutReservations' => $checkOutReservations,
        'cancelledReservations' => $cancelledReservations,
        'guestsOnSite' => $guestsOnSite,
        'latestReservations' => $latestReservations,
        'roomTypeUtilization' => $roomTypeUtilization,
        'roomAvailability' => $roomAvailability,
        'todayIncome' => $todayIncome,
        'calendarData' => $calendarData // Add calendar data to view
    ]);
}

    
    
public function editPrice(Request $request)
{
    // Get available years from reservation data
    $availableYears = DB::table('reservation_details')
        ->select(DB::raw('YEAR(reservation_check_in_date) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Get selected year from request or use current year
    $selectedYear = $request->input('year', date('Y'));

    // Get monthly revenue data for bar graph - only count paid reservations
    $monthlyRevenue = DB::table('reservation_details')
        ->select(
            DB::raw('MONTH(reservation_check_in_date) as month'),
            DB::raw('YEAR(reservation_check_in_date) as year'),
            DB::raw('SUM(CAST(REPLACE(REPLACE(amount, "₱", ""), ",", "") AS DECIMAL(10,2))) as total_revenue')
        )
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    // Format data for chart - prepare arrays for Chart.js
    $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $chartValues = array_fill(0, 12, 0); // Initialize with zeros for all months
    
    foreach ($monthlyRevenue as $revenue) {
        $monthIndex = $revenue->month - 1; // Convert 1-based month to 0-based index
        $chartValues[$monthIndex] = round($revenue->total_revenue, 2);
    }

    // Get total revenue for the selected year
    $totalRevenue = array_sum($chartValues);

    // Get entrance fee from transactions table
    $transactions = Transaction::first();
    $entranceFee = $transactions ? $transactions->entrance_fee : 0;

    // Build base query for reservation details
    $query = DB::table('reservation_details')
        ->join('users', 'reservation_details.user_id', '=', 'users.id')
        ->select(
            'reservation_details.*',
            'users.name as user_name',
            'users.email',
            'users.mobileNo'
        );

    // Apply filters if they exist
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('reservation_check_in_date', [
            $request->start_date,
            $request->end_date
        ]);
    }

    if ($request->filled('guest_name')) {
        $query->where('users.name', 'LIKE', '%' . $request->guest_name . '%');
    }

    if ($request->filled('payment_status')) {
        $query->where('reservation_details.payment_status', $request->payment_status);
    }

    // Get filtered and paginated results
    $reservationDetails = $query
        ->orderBy('reservation_details.created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    // Handle case when no results found
    if ($reservationDetails->isEmpty()) {
        $reservationDetails = DB::table('reservation_details')
            ->join('users', 'reservation_details.user_id', '=', 'users.id')
            ->select(
                'reservation_details.*',
                'users.name as user_name',
                'users.email', 
                'users.mobileNo'
            )
            ->orderBy('reservation_details.created_at', 'desc')
            ->paginate(10);
    }

    // Get pending payments (limit to 4)
    $pendingPayments = DB::table('reservation_details')
        ->join('users', 'reservation_details.user_id', '=', 'users.id')
        ->select('reservation_details.*', 'users.name')
        ->where('payment_status', 'pending')
        ->orderBy('reservation_check_in_date', 'desc')
        ->limit(4)
        ->get();

    return view('AdminSide.Transactions', [
        'chartLabels' => json_encode($chartLabels),
        'chartValues' => json_encode($chartValues),
        'totalRevenue' => $totalRevenue,
        'entranceFee' => $entranceFee,
        'monthlyRevenue' => $monthlyRevenue,
        'availableYears' => $availableYears,
        'pendingPayments' => $pendingPayments,
        'reservationDetails' => $reservationDetails,
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
        $accomodations = Accomodation::paginate(5);
        $countReservedRoom = DB::table('accomodations')
        ->where('accomodation_status', 'unavailable') // ✅ Get only unavailable accommodations
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
