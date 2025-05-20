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
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Exports\ReportsExport;
use Illuminate\Support\Facades\Log;
use App\Models\DamageReport;


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
    public function banGuest($id)
    {
        try {
            // Check if user is already banned
            $user = DB::table('users')->where('id', $id)->first();
            
            if ($user->status === 'banned') {
                return redirect()->back()->with('info', 'User is already banned.');
            }

            // Update user status to banned and invalidate any active sessions
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'status' => 'banned',
                    'updated_at' => now(),
                    'remember_token' => null, // Invalidate remember me token
                    'email_verified_at' => null // Invalidate email verification
                ]);

            // Log the ban action
            $this->recordActivity("Banned user: {$user->name} (ID: {$user->id})");

            return redirect()->back()->with('success', 'Guest has been banned successfully and their account has been disabled.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to ban guest. Please try again.');
        }
    }
    public function guests(){
        // Record activity log for accessing guests page
        $this->recordActivity('Accessed guests management page');

        // Get upcoming reservations count
        $upcomingReservations = DB::table('reservation_details')
            ->whereDate('reservation_check_in_date', '>', Carbon::today()->endOfDay())
            ->count();
        
        // Get checked-in reservations count
        $checkedInReservations = DB::table('reservation_details')
            ->where('reservation_status', 'checked-in')
            ->count();
            
        // Get user and reservation counts
        $users = DB::table('users')->count();
        $reservations = DB::table('users')
        ->leftJoin('reservation_details', 'users.id', '=', 'reservation_details.user_id')
        ->select(
            'users.*',
            DB::raw('COUNT(DISTINCT reservation_details.id) as visit_count'),
            DB::raw('MAX(reservation_details.reservation_check_in_date) as last_visit')
        )
        ->groupBy(
            'users.id',
            'users.name',
            'users.email',
            'users.mobileNo',
            'users.address',
            'users.image',
            'users.created_at',
            'users.updated_at',
            'users.password',
            'users.role',
            'users.status',
            'users.email_verified_at',
            'users.google_id',
            'users.otp',
            'users.otp_expires_at',
            'users.remember_token'
            // Add any other user columns you're using
        )
        ->paginate(10);
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

        // Record activity log with summary statistics
        $this->recordActivity("Viewed guest list - Total Guests: $totalGuests, Upcoming Reservations: $upcomingReservations, Checked-in: $checkedInReservations");
            
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

public function reports(Request $request)
{
    // Get the month and year from request
    $monthYear = $request->input('month_year', date('Y-m'));
    list($selectedYear, $selectedMonth) = explode('-', $monthYear);

    // Get confirmed bookings count
    $confirmedBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->count();

    // Get guest counts
    $adultGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_adults');

    $childGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_children');

    // Get daily booking data
    $dailyBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->selectRaw('DAY(reservation_check_in_date) as day, COUNT(*) as count')
        ->groupBy('day')
        ->get()
        ->pluck('count', 'day')
        ->toArray();

    // Get most booked room type
    $mostBookedRoomType = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->whereNotNull('accomodation_id') // Only include records with accommodation IDs
        ->get()
        ->flatMap(function($reservation) {
            $accomodationIds = json_decode($reservation->accomodation_id, true);
            if (!is_array($accomodationIds)) {
                $accomodationIds = explode(',', $reservation->accomodation_id);
            }
            return array_filter($accomodationIds); // Remove any empty/null values
        })
        ->map(function($id) {
            $accommodation = DB::table('accomodations')
                ->where('accomodation_id', $id)
                ->first();
            return $accommodation ? $accommodation->accomodation_name : null;
        })
        ->filter() // Remove null values
        ->unique() // Get unique room types
        ->first(); // Get the first (most booked) room type
    $totalBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->count();
    // Get cancelled bookings count and calculate percentage
    $cancelledBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'cancelled')
        ->count();

    $cancellationPercentage = $totalBookings > 0 
        ? round(($cancelledBookings / $totalBookings) * 100, 2) 
        : 0;

    // Get checked out count
    $checkedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'checked-out')
        ->count();

    // Get early checked out count
    $earlyCheckedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'early-checked-out')
        ->whereRaw('DATE(updated_at) < reservation_check_out_date')
        ->count();

    // Get monthly income data
    $monthlyIncome = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->select(
            DB::raw('DATE(reservation_check_in_date) as date'),
            DB::raw('SUM(amount) as daily_total')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
    
    // Get payment status breakdown
    $paymentStatusBreakdown = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->select('payment_status', DB::raw('count(*) as count'))
        ->whereIn('payment_status', ['paid', 'pending', 'partial','unpaid','cancelled'])
        ->groupBy('payment_status')
        ->get()
        ->pluck('count', 'payment_status')
        ->toArray();
    
     // Ensure all statuses have a value, default to 0 if not present
     $paymentStatusData = [
        'paid' => $paymentStatusBreakdown['paid'] ?? 0,
        'pending' => $paymentStatusBreakdown['pending'] ?? 0,
        'partial' => $paymentStatusBreakdown['partial'] ?? 0,
        'unpaid' => $paymentStatusBreakdown['unpaid'] ?? 0,
        'cancelled' => $paymentStatusBreakdown['cancelled'] ?? 0
    ];

    $dates = $monthlyIncome->pluck('date')->toArray();
    $income = $monthlyIncome->pluck('daily_total')->toArray();

    // Add export functionality
    if ($request->has('export')) {
        $data = [
            'confirmedBookings' => $confirmedBookings,
            'adultGuests' => $adultGuests,
            'childGuests' => $childGuests,
            'dailyBookings' => $dailyBookings,
            'mostBookedRoomType' => $mostBookedRoomType,
            'cancelledBookings' => $cancelledBookings,
            'cancellationPercentage' => $cancellationPercentage,
            'totalBookings' => $totalBookings,
            'monthlyIncome' => $monthlyIncome,
            'paymentStatusData' => $paymentStatusData,
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear,
            'checkedOutCount' => $checkedOutCount,
            'earlyCheckedOutCount' => $earlyCheckedOutCount
        ];

        if ($request->export === 'pdf') {
            $pdf = PDF::loadView('exports.reports-pdf', $data);
            return $pdf->download('monthly-report-' . $monthYear . '.pdf');
        }

        if ($request->export === 'excel') {
            return Excel::download(new TransactionsExport($data), 'monthly-report-' . $monthYear . '.xlsx');
        }
    }

    return view('AdminSide.Reports', compact(
        'selectedMonth',
        'selectedYear', 
        'confirmedBookings',
        'adultGuests',
        'childGuests',
        'dailyBookings',
        'mostBookedRoomType',
        'cancelledBookings', 
        'cancellationPercentage',
        'totalBookings',
        'dates',
        'income',
        'paymentStatusData',
        'checkedOutCount',
        'earlyCheckedOutCount'
    ));
}


    
    public function logout(){
        auth()->logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

public function login(Request $request) {
    $credentials = $request->only('username', 'password');
    
    // Get admin user from database
    $admin = DB::table('admintbl')->where('username', $credentials['username'])->first();
    
    if (!$admin) {
        return back()->with('error', 'Invalid credentials');
    }

    // Check password - try both plaintext and MD5
    $passwordMatches = false;
    
    // Check plaintext password
    if ($credentials['password'] === $admin->password) {
        $passwordMatches = true;
    }
    
    // Check MD5 hashed password
    if (md5($credentials['password']) === $admin->password) {
        $passwordMatches = true; 
    }

    if ($passwordMatches) {
        // Store admin ID in session
        session(['AdminLogin' => $admin->id]);
        
        // Redirect to dashboard
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
    
    $dailyReservations = DB::table('reservation_details AS rd')
        ->select(
            DB::raw('DATE(rd.created_at) as date'),
            DB::raw('count(*) as total'),
            // Gamitin ang pipe '|' bilang separator sa GROUP_CONCAT
            DB::raw('GROUP_CONCAT(rd.accomodation_id SEPARATOR \'|\') as accomodation_ids')
        )
        ->whereYear('rd.created_at', $selectedYear)
        ->groupBy(DB::raw('DATE(rd.created_at)'))
        ->orderBy('date', 'asc')
        ->get()
        ->map(function($reservation) {
            // I-explode ang string gamit ang pipe separator
            $rawJsonStrings = explode('|', $reservation->accomodation_ids);
            $allAccommodationIds = [];

            foreach ($rawJsonStrings as $jsonString) {
                // I-decode ang bawat JSON string (na dapat ay array ng IDs)
                $decoded = json_decode($jsonString, true);
                if (is_array($decoded)) {
                    // I-merge ang mga IDs sa isang flat array
                    $allAccommodationIds = array_merge($allAccommodationIds, $decoded);
                }
                // Hindi na kailangan ang else block dahil inaasahan natin na JSON array string ang format
            }

            // Alisin ang mga null o empty values
            $allAccommodationIds = array_filter($allAccommodationIds);

            // Fetch room names
            $roomTypes = DB::table('accomodations')
                ->whereIn('accomodation_id', $allAccommodationIds)
                ->pluck('accomodation_name')
                ->toArray();

            return [
                'date' => $reservation->date,
                'total' => $reservation->total,
                'rooms' => $roomTypes
            ];
        });
        $weeklyReservations = DB::table('reservation_details AS rd')
        ->select(
            DB::raw('YEARWEEK(rd.created_at, 1) as week'),
            DB::raw('count(*) as total'),
            // Baguhin din ang separator dito kung pareho ang isyu
            DB::raw('GROUP_CONCAT(rd.accomodation_id SEPARATOR \'|\') as accomodation_ids')
        )
        ->whereYear('rd.created_at', $selectedYear)
        ->groupBy('week')
        ->orderBy('week', 'asc')
        ->get()
        ->map(function($reservation) {
            // I-explode gamit ang pipe
            $rawJsonStrings = explode('|', $reservation->accomodation_ids);
            $allAccommodationIds = [];
    
            foreach ($rawJsonStrings as $jsonString) {
                $decoded = json_decode($jsonString, true);
                if (is_array($decoded)) {
                    $allAccommodationIds = array_merge($allAccommodationIds, $decoded);
                }
            }
    
            $roomTypes = DB::table('accomodations')
                ->whereIn('accomodation_id', $allAccommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
    
            return [
                'week' => $reservation->week,
                'total' => $reservation->total,
                'rooms' => $roomTypes
            ];
        });

        $monthlyReservations = DB::table('reservation_details AS rd')
        ->select(
            DB::raw('DATE_FORMAT(rd.reservation_check_in_date, "%b %Y") as month'),
            DB::raw('count(*) as total'),
            // Baguhin ang separator sa GROUP_CONCAT para sa monthly view
            DB::raw('GROUP_CONCAT(rd.accomodation_id SEPARATOR \'|\') as accomodation_ids')
        )
        ->whereYear('rd.reservation_check_in_date', $selectedYear)
        ->groupBy('month')
        ->orderBy(DB::raw('MIN(rd.reservation_check_in_date)'), 'asc')
        ->get()
        ->map(function($reservation) {
            // I-explode ang string gamit ang pipe separator
            $rawJsonStrings = explode('|', $reservation->accomodation_ids);
            $allAccommodationIds = [];
    
            foreach ($rawJsonStrings as $jsonString) {
                // I-decode ang bawat JSON string (na dapat ay array ng IDs)
                $decoded = json_decode($jsonString, true);
                if (is_array($decoded)) {
                    // I-merge ang mga IDs sa isang flat array
                    $allAccommodationIds = array_merge($allAccommodationIds, $decoded);
                }
            }
    
            // Alisin ang mga null o empty values
            $allAccommodationIds = array_filter($allAccommodationIds);
    
            // Fetch room names
            $roomTypes = DB::table('accomodations')
                ->whereIn('accomodation_id', $allAccommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
    
            return [
                'month' => $reservation->month,
                'total' => $reservation->total,
                'rooms' => $roomTypes
            ];
        });
    
    
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
        ->whereDate('reservation_check_in_date', Carbon::today())
        ->where('payment_status', 'paid')
        ->sum('amount');
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
        ->whereIn('reservation_status', ['checked-in','reserved']) // Get reservations with booked or paid status
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
    $roomColors = [];
    $allRoomTypes = DB::table('accomodations')
        ->select('accomodation_name')
        ->distinct()
        ->get();
    
    $colorPalette = [
        'rgba(255, 99, 132, 0.5)',   // Pink
        'rgba(75, 192, 192, 0.5)',   // Teal
        'rgba(255, 206, 86, 0.5)',   // Yellow
        'rgba(153, 102, 255, 0.5)',  // Purple
        'rgba(255, 159, 64, 0.5)',   // Orange
        'rgba(54, 162, 235, 0.5)',   // Blue
        'rgba(201, 203, 207, 0.5)',  // Gray
        'rgba(255, 127, 80, 0.5)'    // Coral
    ];

    foreach ($allRoomTypes as $index => $room) {
        $colorIndex = $index % count($colorPalette);
        $roomColors[$room->accomodation_name] = $colorPalette[$colorIndex];
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
        'selectedReservations' => $selectedReservations,
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
        'calendarData' => $calendarData,
        'roomColors' => $roomColors // Add room colors to view data
    ]);
}
    // Export to Excel
    
    public function exportExcel(Request $request)
    {
        try {
            return Excel::download(new TransactionsExport($request), 'transactions.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('transactions')->with('error', 'Failed to export Excel file. Please try again.');
        }
    }

public function exportExcelReports(Request $request)
{
    // Get the month and year from request
    $monthYear = $request->input('month_year', date('Y-m'));
    list($selectedYear, $selectedMonth) = explode('-', $monthYear);

    // Get the data for the selected month
    $confirmedBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->count();

    $adultGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_adults');

    $childGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_children');

    $cancelledBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'cancelled')
        ->count();

    $totalBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->count();

    $cancellationPercentage = $totalBookings > 0 ? ($cancelledBookings / $totalBookings) * 100 : 0;

    // Get checked out count
    $checkedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'checked-out')
        ->count();

    // Get early checked out count 
    $earlyCheckedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'early-checked-out')
        ->whereRaw('DATE(updated_at) < reservation_check_out_date')
        ->count();

    // Pass all data to the Excel view
    $data = [
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
        'confirmedBookings' => $confirmedBookings,
        'adultGuests' => $adultGuests,
        'childGuests' => $childGuests,
        'cancelledBookings' => $cancelledBookings,
        'cancellationPercentage' => $cancellationPercentage,
        'checkedOutCount' => $checkedOutCount,
        'earlyCheckedOutCount' => $earlyCheckedOutCount
    ];

    return Excel::download(new ReportsExport($data), 'monthly-report-' . $monthYear . '.xlsx');
}
    // Export to PDF
    public function exportPDF(Request $request)
    {
        try {
            $reservationDetails = Reservation::query()
                ->when($request->start_date, function($query) use ($request) {
                    return $query->where('reservation_check_in_date', '>=', $request->start_date);
                })
                ->when($request->end_date, function($query) use ($request) {
                    return $query->where('reservation_check_in_date', '<=', $request->end_date);
                })
                ->when($request->payment_status, function($query) use ($request) {
                    return $query->where('payment_status', $request->payment_status);
                })
                ->get();

            $pdf = PDF::loadView('exports.transactions-pdf', [
                'transactions' => $reservationDetails
            ]);

            return $pdf->download('transactions.pdf');
            
        } catch (\Exception $e) {
            return redirect()->route('transactions')->with('error', 'Failed to export PDF. Please try again.');
        }
    }

public function exportPDFReports(Request $request)
{
    $monthYear = $request->input('month_year', date('Y-m'));
    list($selectedYear, $selectedMonth) = explode('-', $monthYear);

    // Get confirmed bookings count
    $confirmedBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->count();

    // Get guest counts
    $adultGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_adults');

    $childGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_children');

    $totalBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->count();

    // Get cancelled bookings count and calculate percentage
    $cancelledBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'cancelled')
        ->count();

    $cancellationPercentage = $totalBookings > 0 
        ? round(($cancelledBookings / $totalBookings) * 100, 2) 
        : 0;

    // Get checked out count
    $checkedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'checked-out')
        ->count();

    // Get early checked out count
    $earlyCheckedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'early-checked-out')
        ->whereRaw('DATE(updated_at) < reservation_check_out_date')
        ->count();

    // Get payment status breakdown
    $paymentStatusBreakdown = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->select('payment_status', DB::raw('count(*) as count'))
        ->whereIn('payment_status', ['paid', 'pending', 'partial','unpaid','cancelled'])
        ->groupBy('payment_status')
        ->get()
        ->pluck('count', 'payment_status')
        ->toArray();

    $data = [
        'confirmedBookings' => $confirmedBookings,
        'adultGuests' => $adultGuests,
        'childGuests' => $childGuests,
        'totalBookings' => $totalBookings,
        'cancelledBookings' => $cancelledBookings,
        'cancellationPercentage' => $cancellationPercentage,
        'checkedOutCount' => $checkedOutCount,
        'earlyCheckedOutCount' => $earlyCheckedOutCount,
        'paymentStatusData' => $paymentStatusBreakdown,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear
    ];

    $pdf = PDF::loadView('exports.reports-pdf', $data);
    return $pdf->download('monthly-report-' . $monthYear . '.pdf');
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
            ->paginate(5)
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

        // Get all transaction data
        $transactions = DB::table('transaction')
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
            'transactions' => $transactions,
        ]);
    }
public function printReport(Request $request)
{
    // Get the month and year from request
    $monthYear = $request->input('month_year', date('Y-m'));
    list($selectedYear, $selectedMonth) = explode('-', $monthYear);

    // Get total bookings count
    $totalBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->count();

    // Reuse the same data collection logic from the reports method
    $confirmedBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->count();

    $adultGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_adults');

    $childGuests = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->sum('number_of_children');

    // Get checked out count
    $checkedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'checked-out')
        ->count();

    // Get early checked out count
    $earlyCheckedOutCount = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'early-checked-out')
        ->whereRaw('DATE(updated_at) < reservation_check_out_date')
        ->count();

    // Get cancelled bookings count
    $cancelledBookings = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('reservation_status', 'cancelled')
        ->count();

    // Calculate cancellation percentage
    $cancellationPercentage = $totalBookings > 0 
        ? round(($cancelledBookings / $totalBookings) * 100, 2)
        : 0;

    // Get most booked room type
    $mostBookedRoomType = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->where('payment_status', 'paid')
        ->whereNotNull('accomodation_id')
        ->get()
        ->flatMap(function($reservation) {
            $accomodationIds = json_decode($reservation->accomodation_id, true);
            if (!is_array($accomodationIds)) {
                $accomodationIds = explode(',', $reservation->accomodation_id);
            }
            return array_filter($accomodationIds);
        })
        ->map(function($id) {
            $accommodation = DB::table('accomodations')
                ->where('accomodation_id', $id)
                ->first();
            return $accommodation ? $accommodation->accomodation_name : null;
        })
        ->filter()
        ->unique()
        ->first();

    // Get payment status breakdown
    $paymentStatusBreakdown = DB::table('reservation_details')
        ->whereYear('reservation_check_in_date', $selectedYear)
        ->whereMonth('reservation_check_in_date', $selectedMonth)
        ->select('payment_status', DB::raw('count(*) as count'))
        ->whereIn('payment_status', ['paid', 'pending', 'partial','unpaid','cancelled'])
        ->groupBy('payment_status')
        ->get()
        ->pluck('count', 'payment_status')
        ->toArray();

    // Ensure all payment statuses have a value
    $paymentStatusData = [
        'paid' => $paymentStatusBreakdown['paid'] ?? 0,
        'pending' => $paymentStatusBreakdown['pending'] ?? 0,
        'partial' => $paymentStatusBreakdown['partial'] ?? 0,
        'unpaid' => $paymentStatusBreakdown['unpaid'] ?? 0,
        'cancelled' => $paymentStatusBreakdown['cancelled'] ?? 0
    ];

    return view('exports.reports-print', compact(
        'selectedMonth',
        'selectedYear',
        'confirmedBookings',
        'adultGuests', 
        'childGuests',
        'totalBookings',
        'cancelledBookings',
        'cancellationPercentage',
        'paymentStatusData',
        'mostBookedRoomType',
        'checkedOutCount',
        'earlyCheckedOutCount'
    ));
}

public function updatePrice(Request $request)
{
    \Log::info('Update Price Request:', $request->all());
    
    try {
        $request->validate([
            'entrance_fee' => 'required',
            'type' => 'required|string',
            'age_range' => 'required|string', 
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'fee_id' => 'required|integer',
            'session' => 'required|string'
        ]);

        $fee = Transaction::findOrFail($request->fee_id);
        \Log::info('Found Fee:', ['fee' => $fee]);
        
        $fee->update([
            'entrance_fee' => $request->entrance_fee,
            'type' => $request->type,
            'age_range' => $request->age_range,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'session' => $request->session
        ]);
        
        \Log::info('Updated Fee:', ['fee' => $fee]);
        return redirect()->route('transactions')->with('success', 'Entrance fee updated successfully!');
        
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        \Log::error('Fee not found:', ['fee_id' => $request->fee_id]);
        return redirect()->route('transactions')->with('error', 'Fee record not found');
    } catch (\Exception $e) {
        \Log::error('Update Error:', ['error' => $e->getMessage()]);
        return redirect()->route('transactions')->with('error', 'Failed to update: ' . $e->getMessage());
    }
}
public function addPrice(Request $request)
{
    
    // Validate the request
    $request->validate([
        'type' => 'required|string',
        'entrance_fee' => 'required|numeric|min:0',
        'age_range' => 'required|string',
        'session' => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time'
    ]);

    try {
        // Insert new price adjustment
        DB::table('transaction')->insert([
            'type' => $request->type,
            'entrance_fee' => $request->entrance_fee,
            'age_range' => $request->age_range,
            'session' => $request->session,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Log the activity
        $this->recordActivity("Added entrance fee adjustment for {$request->type}");

        return back()->with('success', 'Entrance fee added successfully');

    } catch (\Exception $e) {
        return back()->with('error', 'Failed to add entrance fee adjustment: ' . $e->getMessage());
    }
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
        $accomodations = Accomodation::paginate(10);
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

public function ActivityLogs(Request $request)
{
    // Get distinct roles from activity_logs table
    $roles = DB::table('activity_logs')
        ->select('role')
        ->distinct()
        ->pluck('role');

    $query = DB::table('activity_logs')
        ->orderBy('date', 'desc')
        ->orderBy('time', 'desc');

    // Date range filter
    if ($request->filled('start_date')) {
        $query->where('date', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->where('date', '<=', $request->end_date);
    }

    // Role filter using roles from database
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('activity', 'LIKE', "%{$search}%")
              ->orWhere('user', 'LIKE', "%{$search}%");
        });
    }

    $activityLogs = $query->paginate(10)->withQueryString();

    return view('AdminSide.ActivityLogs', compact('activityLogs', 'roles'));
}

    // Helper function to record new activity logs
public function recordActivity($activity)
{
    // Get current admin info from session
    $adminId = session('AdminLogin');
    $admin = DB::table('admintbl')->where('id', $adminId)->first();
    
    // Insert activity log
    DB::table('activity_logs')->insert([
        'date' => now()->toDateString(),
        'time' => now()->toTimeString(),
        'user' => $admin ? $admin->username : 'System',
        'role' => 'Admin', // Since this is for admin table
        'activity' => $activity,
        'created_at' => now(),
        'updated_at' => now()
    ]);
}
public function UserAccountRoles()
{
    // Get all staff accounts from stafftbl
// Get all staff accounts with pagination and search functionality
$query = DB::table('stafftbl')
    ->select('id', 'username','password', 'status', 'created_at', 'updated_at');

// Apply search filter if provided
if (request()->has('search')) {
    $search = request()->search;
    $query->where('username', 'LIKE', "%{$search}%");
}

// Apply status filter if provided
if (request()->has('status')) {
    $query->where('status', request()->status);
}

$staffAccounts = $query
    ->orderBy('created_at', 'desc')
    ->paginate(10)
    ->withQueryString();

    // Pass staff accounts data to the view
    return view('AdminSide.AccountCreation', [
        'staffAccounts' => $staffAccounts
    ]);
}
    
public function addUser(Request $request)
{
    // Validate the request
    $request->validate([
        'username' => 'required|string|max:255|unique:stafftbl',
        'password' => 'required|string|min:6',
        'status' => 'required|string'
    ]);

    try {
        // Create new staff record
        DB::table('stafftbl')->insert([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Hash the password
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Record the activity
        $this->recordActivity("Created new {$request->role} account: {$request->username}");

        return redirect()->route('userAccountRoles')->with('success', 'User account created successfully!');
    } catch (\Exception $e) {
        return redirect()->route('userAccountRoles')->with('error', 'Failed to create user account. Please try again.');
    }
}
public function updateUser(Request $request, $id)
{
    // Validate the request
    $request->validate([
        'username' => 'required|string|max:255|unique:stafftbl,username,'.$id,
        'password' => 'nullable|string|min:6',
        'status' => 'required|string'
    ]);

    try {
        // Get current user data
        $user = DB::table('stafftbl')->where('id', $id)->first();
        if (!$user) {
            return redirect()->route('userAccountRoles')->with('error', 'User not found.');
        }

        // Prepare update data
        $updateData = [
            'username' => $request->username,
            'status' => $request->status,
            'updated_at' => now()
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Update user record
        DB::table('stafftbl')
            ->where('id', $id)
            ->update($updateData);

        // Record the activity
        $this->recordActivity("Updated user account: {$request->username}");

        return redirect()->route('userAccountRoles')->with('success', 'User account updated successfully!');
    } catch (\Exception $e) {
        return redirect()->route('userAccountRoles')->with('error', 'Failed to update user account. Please try again.');
    }
}
    public function DamageReport(){
        $damageReports = DamageReport::orderBy('created_at', 'desc')
            ->paginate(5);

        return view ('AdminSide.DamageReport', compact('damageReports'));
    }
    public function editDamageReport(Request $request, $id)
{
    try {
        // Log the incoming request data
        Log::info('Damage Report Update - Request Data:', [
            'id' => $id,
            'request_data' => $request->all()
        ]);

        // Validate the request
        $request->validate([
            'notes' => 'required|string',
            'damage_description' => 'required|string',
            'status' => 'required'  // Ensure these match your database enum values
        ]);

        // Update the damage report
        $updated = DB::table('damage_reports')
            ->where('id', $id)
            ->update([
                'notes' => $request->notes,
                'damage_description' => $request->damage_description,
                'status' => $request->status,
                'updated_at' => now()
            ]);

        if ($updated) {
            return redirect()->back()->with('success', 'Damage report updated successfully');
        }

        return redirect()->back()->with('error', 'No changes were made to the damage report');
    } catch (\Exception $e) {
        Log::error('Damage Report Update - Error:', [
            'id' => $id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Error updating damage report: ' . $e->getMessage());
    }
}

    
}
