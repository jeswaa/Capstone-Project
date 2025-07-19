<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\Package;
use App\Models\Accomodation;
use App\Models\Transaction;
use App\Models\Reservation;
use App\Models\Feedback;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReservationNotification;


class ReservationController extends Controller
{
    public function reservation()
    {
        return view('Reservation.reservation');
    }
    public function fetchAddons()
    {
        $addons = DB::table('addons')->get();
        return view('Reservation.addons', ['addons' => $addons]);
    }
    public function checkAccommodationAvailability(Request $request)
{
    \Log::info('=== STARTING AVAILABILITY CHECK ===', [
        'checkIn' => $request->checkIn,
        'checkOut' => $request->checkOut
    ]);

    try {
        $checkIn = Carbon::parse($request->checkIn);
        $checkOut = Carbon::parse($request->checkOut);

        // 1. Get all active accommodations
        $accommodations = DB::table('accomodations')
            ->where('accomodation_status', 'available')
            ->get();

        \Log::debug('Total accommodations loaded', ['count' => count($accommodations)]);

        // 2. Find accommodations with ANY reservations during dates
        $bookedIds = DB::table('reservation_details')
            ->where('reservation_check_out_date', '>', $checkIn)
            ->where('reservation_check_in_date', '<', $checkOut)
            ->whereIn('reservation_status', ['reserved', 'checked-in'])
            ->pluck('accomodation_id')
            ->unique();

        \Log::debug('Booked accommodation IDs', ['ids' => $bookedIds]);

        // 3. Filter out ANY accommodation with reservations
        $available = $accommodations->reject(function ($accom) use ($bookedIds) {
            return $bookedIds->contains($accom->accomodation_id);
        });

        \Log::info('Available accommodations', [
            'count' => $available->count(),
            'ids' => $available->pluck('accomodation_id')
        ]);

        return response()->json([
            'available_accommodations' => $available->map(function ($accom) {
                return [
                    'id' => $accom->accomodation_id,
                    'name' => $accom->accomodation_name,
                    'total_quantity' => $accom->quantity,
                    'available_quantity' => $accom->quantity // All rooms available
                ];
            })
        ]);

    } catch (\Exception $e) {
        \Log::error('ERROR: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}
public function selectPackageCustom(Request $request)
{
    $checkIn = $request->query('checkIn');
    $checkOut = $request->query('checkOut');

    // Validate dates
    if ($checkIn && $checkOut) {
        try {
            $start = Carbon::parse($checkIn);
            $end = Carbon::parse($checkOut);
            
            if ($end <= $start) {
                return back()->with('error', 'Check-out date must be after check-in date');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid date format');
        }
    }

    // Get all active accommodations (original quantities preserved)
    $accommodations = DB::table('accomodations')
        ->where('accomodation_status', 'available')
        ->get();

    if ($checkIn && $checkOut) {
        // Get summed reservations per accommodation in one query
        $reservedQuantities = DB::table('reservation_details')
            ->select('accomodation_id', DB::raw('SUM(quantity) as total_reserved'))
            ->where('reservation_check_out_date', '>', $checkIn)
            ->where('reservation_check_in_date', '<', $checkOut)
            ->whereNull('deleted_at')
            ->whereIn('reservation_status', ['reserved', 'checked-in'])
            ->groupBy('accomodation_id')
            ->pluck('total_reserved', 'accomodation_id');

        // Filter accommodations
        $accommodations = $accommodations->filter(function ($accomodation) use ($reservedQuantities) {
            $reserved = $reservedQuantities[$accomodation->accomodation_id] ?? 0;
            $available = $accomodation->quantity - $reserved;
            
            // Only keep accommodations with availability
            if ($available > 0) {
                $accomodation->available_quantity = $available;
                return true;
            }
            return false;
        });
    } else {
        // When no dates selected, show all with full availability
        $accommodations->each(function ($accomodation) {
            $accomodation->available_quantity = $accomodation->quantity;
        });
    }

    return view('Reservation.selectPackageCustom', [
        'accomodations' => $accommodations,
        'check_in_date' => $checkIn,
        'check_out_date' => $checkOut,
        'activities' => DB::table('activitiestbl')->get(),
        'transactions' => DB::table('transaction')->first(),
    ]);
}

    public function paymentProcess()
    {
        // Retrieve reservation details from session
        $reservationDetails = session('reservation_details');
    
        if (!$reservationDetails) {
            $reservationDetails = Reservation::where('user_id', Auth::id())->latest()->first();
        }
    
        // If no reservation is found, return error
        if (!$reservationDetails) {
            return back()->with('error', 'No reservation found. Please complete the reservation first.');
        }
    
        // Convert stdClass to array if retrieved from database
        if (is_object($reservationDetails)) {
            $reservationDetails = (array) $reservationDetails;
        }
    
        $packages = Package::all();
    
        // Ensure accommodation IDs are properly handled
        $accomodationIds = isset($reservationDetails['accomodation_id']) 
            ? json_decode($reservationDetails['accomodation_id'], true) 
            : [];
    
        // Fetch accommodation details and compute total accommodation price
        $accomodations = DB::table('accomodations')->whereIn('accomodation_id', $accomodationIds)->get();
        $totalAccomodationPrice = $accomodations->sum('accomodation_price');
    
        // Kunin ang entrance fee mula sa session
        $totalEntranceFee = session('entrance_fee', 0);
    
        return view('Reservation.paymentProcess', compact(
            'reservationDetails', 
            'packages', 
            'totalEntranceFee', 
            'totalAccomodationPrice', 
            'accomodations'
        ));
    }

    public function summary(){
        return view('Reservation.summary');
    }

    public function EventsReservation(){
        return view('Reservation.Events_Reservation');
    }

    public function fetchUserData(){
        $user = User::find(Auth::user()->id);
        return $user;
    }
    public function fetchAccomodationData()
    {
        $accomodations = DB::table('accomodations')
            ->where('accomodation_status', 'available')
            ->get();
        $activities = DB::table('activitiestbl')->get();
        $transactions = DB::table('transaction')->first();
        $adultTransaction = Transaction::where('type', 'adult')->select('entrance_fee')->first();
        $kidTransaction = Transaction::where('type', 'kid')->select('entrance_fee')->first();
        
        return view('Reservation.selectPackage', [
            'accomodations' => $accomodations, 
            'activities' => $activities, 
            'transactions' => $transactions,
            'adultTransaction' => $adultTransaction,
            'kidTransaction' => $kidTransaction
        ]);
    }
    
    public function saveReservationDetails(Request $request) 
    {
        
        // Retrieve reservation details from session instead of database
        $reservationDetails = session('reservation_details');
    
        if (!$reservationDetails) {
            return redirect()->route('selectPackage')->with('error', 'No reservation details found. Please start the reservation process again.');
        }
    
        // Fetch user details automatically (assuming they are stored in Auth or another source)
        $user = Auth::user();
        $reservationDetails['name'] = $user->name ?? 'Guest';
        $reservationDetails['email'] = $user->email ?? null;
        $reservationDetails['mobileNo'] = $user->mobileNo ?? null;
        $reservationDetails['address'] = $user->address ?? null;
    
        // Update session with new details
        session(['reservation_details' => $reservationDetails]);
    
        // Retrieve related package and accommodations
        $selectedPackage = Package::find($reservationDetails['package_id'] ?? null);
        $accommodationIds = json_decode($reservationDetails['accomodation_id'] ?? '[]', true);
        $accommodations = DB::table('accomodations')->whereIn('accomodation_id', $accommodationIds)->get();
        $activityIds = json_decode($reservationDetails['activity_id'] ?? '[]', true);
        $activities = DB::table('activitiestbl')->whereIn('id', $activityIds)->get();
    
        return redirect()->route('paymentProcess')->with([
            'success' => 'Reservation details stored successfully.',
            'selectedPackage' => $selectedPackage,
            'accommodations' => $accommodations,
            'activities' => $activities
        ]);
    }
    
    

    public function OnedayStay(Request $request)
{
    try {
        $request->validate([
            'reservation_check_in_date' => 'required|date|after_or_equal:today',
            'reservation_check_out_date' => 'required|date|after_or_equal:reservation_check_in_date',
            'reservation_check_in' => 'required|date_format:H:i',
            'reservation_check_out' => 'required|date_format:H:i',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0',
            'special_request' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:1'
        ], [
            'number_of_adults.required' => 'At least one adult must be included.',
            'number_of_adults.min' => 'At least one adult must be included.',
            'number_of_children.min' => 'Number of children cannot be negative.',
            'quantity.required' => 'Please select number of rooms.',
            'quantity.min' => 'Please select at least one room.',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    }
    
    // Validate selected accommodations
    $selectedAccommodationIds = (array) $request->input('accomodation_id');
    if (empty($selectedAccommodationIds)) {
        return redirect()->back()->with('error', 'Please select at least one accommodation.');
    }

    // If single value is received, convert it to array
    if (!is_array($selectedAccommodationIds)) {
        $selectedAccommodationIds = [$selectedAccommodationIds];
    }

    // Fetch accommodation prices
    $accommodations = DB::table('accomodations')
        ->whereIn('accomodation_id', $selectedAccommodationIds)
        ->get();
    
    $accommodationPrice = (float) $accommodations->sum('accomodation_price') * $request->input('quantity', 1);

    // Handle activity selection (store as JSON if multiple)
    $activityIds = $request->input('activity_id', []);
    $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);

    // Compute entrance fee
    $numAdults = (int) $request->input('number_of_adults', 0);
    $numChildren = (int) $request->input('number_of_children', 0);
    
    // Get entrance fees from transaction table based on session
    $session = $request->input('session', 'morning');
    $adultFee = Transaction::where('type', 'adult')
        ->where('session', $session)
        ->value('entrance_fee') ?? 0;
    $kidFee = Transaction::where('type', 'kid')
        ->where('session', $session)
        ->value('entrance_fee') ?? 0;
    
    // Calculate total entrance fee
    $entranceFee = ($numAdults * $adultFee) + ($numChildren * $kidFee);
    session()->put('entrance_fee', $entranceFee);

    // Compute total price
    $totalPrice = $entranceFee + $accommodationPrice;

    // Store reservation details in session
    $reservationData = [
        'user_id' => Auth::id(),
        'accomodation_id' => json_encode($selectedAccommodationIds),
        'activity_id' => $selectedActivityId,
        'rent_as_whole' => $request->input('rent_as_whole'),
        'reservation_check_in' => $request->input('reservation_check_in'),
        'reservation_check_out' => $request->input('reservation_check_out'),
        'reservation_check_in_date' => $request->input('reservation_check_in_date'),
        'reservation_check_out_date' => $request->input('reservation_check_out_date'),
        'special_request' => $request->input('special_request'),
        'quantity' => $request->input('quantity', 1),
        'total_guest' => $numAdults + $numChildren,
        'number_of_adults' => $numAdults,
        'number_of_children' => $numChildren,
        'amount' => $totalPrice,
        'session' => $session
    ];

    session()->put('reservation_details', $reservationData);

    // Log all session data
    Log::info('Reservation Details Saved to Session', [
        'user_id' => Auth::id(),
        'session_data' => $reservationData,
        'accommodation_details' => [
            'selected_ids' => $selectedAccommodationIds,
            'accommodation_price' => $accommodationPrice
        ],
        'activity_details' => [
            'activity_ids' => $activityIds,
            'selected_activity_id' => $selectedActivityId
        ],
        'guest_details' => [
            'adults' => $numAdults,
            'children' => $numChildren,
            'total_guests' => $numAdults + $numChildren
        ],
        'price_details' => [
            'accommodation_price' => $accommodationPrice,
            'entrance_fee' => $entranceFee,
            'total_price' => $totalPrice
        ],
        'timestamp' => now()->toDateTimeString()
    ]);

    return redirect()->route('paymentProcess')->with('success', 'Package selection saved successfully.');
}

    public function getSessionTimes(Request $request) {
        $session = $request->query('session');

        // Get session times and entrance fee from transaction table
        $transaction = \App\Models\Transaction::where('session', $session)->first();

        if ($transaction) {
            $start_time = $transaction->start_time;
            $end_time = $transaction->end_time;
            $entrance_fee = $transaction->entrance_fee;
        } else {
            // Default values if no session found
            $start_time = null;
            $end_time = null;
            $entrance_fee = null;
        }
        $adultTransaction = Transaction::where('type', 'adult')
        ->where('session', $session)
        ->first();
        
        $kidTransaction = Transaction::where('type', 'kid')
            ->where('session', $session)
            ->first();

        return response()->json([
            'start_time' => $start_time,
            'end_time' => $end_time,
            'entrance_fee' => $entrance_fee,
            'adultFee' => $adultTransaction->entrance_fee,
            'kidFee' => $kidTransaction->entrance_fee
        ]);
    }


    public function SessionTimeOnly(Request $request) {
        $session = $request->query('session');
        // Get session times and entrance fee from transaction table
        $transaction = \App\Models\Transaction::where('session', $session)->first();
        
        if ($transaction) {
            $start_time = $transaction->start_time;
            $end_time = $transaction->end_time;
        } else {
            // Default values if no session found
            $start_time = null;
            $end_time = null;
        }

        return response()->json([
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);
    }
    
        public function StayInPackages(Request $request)
    {
        try {
            $request->validate([
                'reservation_check_in_date' => 'required|date|after_or_equal:today',
                'reservation_check_out_date' => 'required|date|after_or_equal:reservation_check_in_date',
                'reservation_check_in' => 'required|date_format:H:i',
                'reservation_check_out' => 'required|date_format:H:i',
                'number_of_adults' => 'required|integer|min:1',
                'number_of_children' => 'required|integer|min:0',
                'special_request' => 'nullable|string|max:500',
                'quantity' => 'required|integer|min:1'
            ], [
                'number_of_adults.required' => 'At least one adult must be included.',
                'number_of_adults.min' => 'At least one adult must be included.',
                'number_of_children.min' => 'Number of children cannot be negative.',
                'quantity.required' => 'Please select number of rooms.',
                'quantity.min' => 'Please select at least one room.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Validate selected accommodations
        $selectedAccommodationIds = $request->input('accomodation_id', []);
        if (empty($selectedAccommodationIds)) {
            return redirect()->back()->with('error', 'Please select at least one accommodation.');
        }
    
        // Fetch accommodation prices
        $accommodations = DB::table('accomodations')
            ->whereIn('accomodation_id', $selectedAccommodationIds)
            ->get();
        
        $accommodationPrice = (float) $accommodations->sum('accomodation_price') * $request->input('quantity', 1);
    
        // Handle activity selection (store as JSON if multiple)
        $activityIds = $request->input('activity_id', []);
        $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);
    
        // Compute entrance fee
        $numAdults = (int) $request->input('number_of_adults', 0);
        $numChildren = (int) $request->input('number_of_children', 0);
    
        // Compute total price
        $totalPrice = $accommodationPrice;
        session()->put('entrance_fee', 0);
    
        // Store reservation details in session
        $reservationData = [
            'user_id' => Auth::id(),
            'accomodation_id' => json_encode($selectedAccommodationIds),
            'activity_id' => $selectedActivityId,
            'rent_as_whole' => $request->input('rent_as_whole'),
            'reservation_check_in' => $request->input('reservation_check_in'),
            'reservation_check_out' => $request->input('reservation_check_out'),
            'reservation_check_in_date' => $request->input('reservation_check_in_date'),
            'reservation_check_out_date' => $request->input('reservation_check_out_date'),
            'special_request' => $request->input('special_request'),
            'quantity' => $request->input('quantity', 1),
            'total_guest' => $numAdults + $numChildren,
            'number_of_adults' => $numAdults,
            'number_of_children' => $numChildren,
            'amount' => $totalPrice,
        ];

        session()->put('reservation_details', $reservationData);

        // Log all session data
        Log::info('Reservation Details Saved to Session', [
            'user_id' => Auth::id(),
            'session_data' => $reservationData,
            'accommodation_details' => [
                'selected_ids' => $selectedAccommodationIds,
                'accommodation_price' => $accommodationPrice
            ],
            'activity_details' => [
                'activity_ids' => $activityIds,
                'selected_activity_id' => $selectedActivityId
            ],
            'guest_details' => [
                'adults' => $numAdults,
                'children' => $numChildren,
                'total_guests' => $numAdults + $numChildren
            ],
            'price_details' => [
                'accommodation_price' => $accommodationPrice,
                'total_price' => $totalPrice
            ],
            'timestamp' => now()->toDateTimeString()
        ]);
    
            return redirect()->route('paymentProcess')->with('success', 'Package selection saved successfully.');
    }

    private function isDateAvailable($date)
    {
        return !Reservation::where('reservation_check_in_date', $date)
            ->orWhere('reservation_check_out_date', $date)
            ->exists();
    }


public function savePaymentProcess(Request $request)
{
    
    // Retrieve reservation details from session instead of database
    $reservationDetails = session('reservation_details');

    if (!$reservationDetails) {
        return redirect()->route('summary')->with('error', 'No reservation details found. Please complete the reservation process.');
    }
    
    // Ensure reservationDetails is an array
    if (!is_array($reservationDetails)) {
        $reservationDetails = (array) $reservationDetails;
    }

    $total_amount = $request->input('total_amount'); 
    // Check if `accomodation_id` exists before decoding
    $accomodationIds = isset($reservationDetails['accomodation_id']) 
        ? json_decode($reservationDetails['accomodation_id'], true) 
        : [];
    
    // Ensure it's an array
    $accomodationIds = is_array($accomodationIds) ? json_encode($accomodationIds) : json_encode([]);
    
    // Store payment details in session
    $reservationDetails['amount'] = str_replace(['₱', ' ', ','], '', $request->input('amount'));
    $reservationDetails['downpayment'] = str_replace(['₱', ' ', ','], '', $request->input('downpayment'));
    $reservationDetails['balance'] = str_replace(['₱', ' ', ','], '', $request->input('balance'));
    $reservationDetails['payment_method'] = $request->input('payment_method', 'gcash');
    $reservationDetails['mobileNo'] = $request->input('mobileNo');
    $reservationDetails['upload_payment'] = $request->file('upload_payment')->store('public/payments');
    $reservationDetails['reference_num'] = $request->input('reference_num');
    $reservationDetails['payment_status'] = 'pending';
    $reservationDetails['reservation_status'] = 'pending';
    $request->session()->put('entrance_fee', $request->entrance_fee);   
    
    // Save reservation details to database
    $reservation = new Reservation();
    $reservation->user_id = Auth::id();
    $reservation->name = Auth::user()->name;
    $reservation->email = Auth::user()->email;
    $reservation->address = Auth::user()->address;
    $reservation->total_guest = $reservationDetails['total_guest'] ?? 0;
    $reservation->number_of_adults = $reservationDetails['number_of_adults'] ?? 0;
    $reservation->number_of_children = $reservationDetails['number_of_children'] ?? 0;
    $reservation->accomodation_id = $accomodationIds;
    $reservation->activity_id = $reservationDetails['activity_id'] ?? null;
    $reservation->reservation_check_in_date = $reservationDetails['reservation_check_in_date'] ?? null;
    $reservation->reservation_check_out_date = $reservationDetails['reservation_check_out_date'] ?? null;
    $reservation->reservation_check_in = $reservationDetails['reservation_check_in'] ?? null;
    $reservation->reservation_check_out = $reservationDetails['reservation_check_out'] ?? null;
    $reservation->quantity = $reservationDetails['quantity'] ?? 1;
    $reservation->special_request = $reservationDetails['special_request'] ?? null;
    $reservation->amount = floatval($reservationDetails['amount']);
    $reservation->balance = floatval($reservationDetails['balance']);
    $reservation->downpayment = floatval($reservationDetails['downpayment']);
    $reservation->payment_method = $reservationDetails['payment_method'];
    $reservation->mobileNo = $reservationDetails['mobileNo'];
    $reservation->upload_payment = $reservationDetails['upload_payment'];
    $reservation->reference_num = $reservationDetails['reference_num'];
    $reservation->payment_status = $reservationDetails['payment_status'];
    $reservation->reservation_status = $reservationDetails['reservation_status'];
    $reservation->save();
    // Clear session after saving to database
    session()->forget('reservation_details');
    
    // Retrieve admin email and send notification
    $adminEmail = DB::table('settings')->where('key', 'admin_email')->value('value');
    Mail::to($adminEmail)->send(new NewReservationNotification($reservation));

    // Get accommodations data
    $accommodationIds = json_decode($reservation->accomodation_id, true);
    $accommodations = DB::table('accomodations')
        ->whereIn('accomodation_id', (array) $accommodationIds)
        ->get();

    // Redirect with flash data
    return redirect()->route('summary')->with([
        'success' => 'Reservation saved.Wait for the staff to process your reservation.Thank you!',
        'amount' => $total_amount,
        'accommodations' => $accommodations
    ]);
}

    public function displayReservationSummary()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your reservation summary.');
        }

        $userId = Auth::user()->id;

        // Fetch latest reservation
        $reservationDetails = DB::table('reservation_details')
        ->where('reservation_details.user_id', $userId)
        ->select('reservation_details.*')
        ->latest('reservation_details.created_at')
        ->first();


        // Redirect if no reservation found
        if (!$reservationDetails) {
            return redirect()->back()->with('error', 'No reservations found.');
        }

        // --- Fetch Activities ---
        $activityIds = json_decode($reservationDetails->activity_id, true);
        $activities = [];

        if (is_array($activityIds) && count($activityIds) > 0) {
            $activities = DB::table('activitiestbl')
                ->whereIn('id', $activityIds)
                ->pluck('activity_name')
                ->toArray();
        } elseif (is_numeric($activityIds)) { // Handle single integer
            $activities = DB::table('activitiestbl')
                ->where('id', $activityIds)
                ->pluck('activity_name')
                ->toArray();
        }

        // --- Fetch Accommodations ---
        $accommodationIds = json_decode($reservationDetails->accomodation_id, true);
        $accommodations = [];

        if (is_array($accommodationIds) && count($accommodationIds) > 0) {
            $accommodations = DB::table('accomodations')
                ->whereIn('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        } elseif (is_numeric($accommodationIds)) { // Handle single integer
            $accommodations = DB::table('accomodations')
                ->where('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        }
        return view('Reservation.summary', [
            'reservationDetails' => $reservationDetails,
            'activities' => $activities,
            'accommodations' => $accommodations
        ]);
    }

public function showReservationsInCalendar()
{
    $userId = Auth::id();
    $events = [];

    // Fetch user's own reservations
    $userReservations = DB::table('reservation_details')
        ->where('user_id', $userId)
        ->whereIn('reservation_status', ['reserved', 'checked-in'])
        ->get();

    foreach ($userReservations as $reservation) {
        $accommodationIds = json_decode($reservation->accomodation_id, true);
        $accommodations = DB::table('accomodations')
            ->whereIn('accomodation_id', (array) $accommodationIds)
            ->pluck('accomodation_name')
            ->toArray();

        $activityIds = json_decode($reservation->activity_id, true);
        $activities = DB::table('activitiestbl')
            ->whereIn('id', (array) $activityIds)
            ->pluck('activity_name')
            ->toArray();

        $events[] = [
            'title' => 'Your Reservation',
            'start' => \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('Y-m-d'),
            'allDay' => true,
            'color' => $reservation->reservation_status === 'checked-in' ? '#2ecc71' : '#97a97c',
            'extendedProps' => [
                'user_id' => (int) $reservation->user_id,
                'name' => $reservation->name,
                'check_in' => $reservation->reservation_check_in,
                'check_out' => $reservation->reservation_check_out,
                'room_type' => $package->package_room_type ?? '',
                'accommodations' => implode(", ", $accommodations),
                'activities' => implode(", ", $activities),
                'status' => $reservation->reservation_status
            ],
        ];
    }

    // Get Fully Booked Dates
    $fullyBookedDates = DB::table('reservation_details')
        ->whereIn('reservation_status', ['reserved', 'checked-in'])
        ->select('reservation_check_in_date')
        ->groupBy('reservation_check_in_date')
        ->havingRaw('COUNT(*) >= (SELECT COUNT(*) FROM accomodations)')
        ->pluck('reservation_check_in_date')
        ->toArray();

    // Add Fully Booked events
    foreach ($fullyBookedDates as $date) {
        $events[] = [
            'title' => 'Fully Booked',
            'start' => $date,
            'allDay' => true,
            'color' => '#FF0000',
            'textColor' => 'white'
        ];
    }

    return view('Reservation.Events_reservation', compact('events', 'userId'));
}
    public function guestcancelReservation(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255'
        ]);

        $reservation = DB::table('reservation_details')->where('id', $id)->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        // Update status to "cancelled" and save the reason
        DB::table('reservation_details')->where('id', $reservation->id)->update([
            'cancel_reason' => $request->cancel_reason,
            'payment_status' => 'cancelled',
            'reservation_status' => 'cancelled'
        ]);

        return redirect()->route('profile')->with('success', 'Reservation cancelled successfully.');
    }
    
    public function reservationSummary()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }

        $reservations = Reservation::where('user_id', $user->id)->latest()->get();
        if ($reservations->isEmpty()) {
            return redirect()->back()->with('error', 'No reservations found.');
        }

        return view('FrontEnd.profilepageReservation', compact('reservations'));
    }
    public function getAvailableAccommodations(Request $request)
    {
        $selectedDate = $request->input('date');

        // Kunin lahat ng accommodations
        $accommodations = Accomodation::all();

        // Kunin lahat ng reservations sa napiling date
        $reservedAccommodations = Reservation::where('reservation_check_in_date', '<=', $selectedDate)
            ->where('reservation_check_out_date', '>', $selectedDate)
            ->whereNotIn('reservation_status', ['checked_out', 'cancelled'])
            ->pluck('accomodation_id')
            ->toArray();

        // Markahan ang mga hindi available
        foreach ($accommodations as $accommodation) {
            $accommodation->is_available = !in_array($accommodation->id, $reservedAccommodations);
        }

        return redirect()->back()->with('accommodations', $accommodations);
    }
    public function homepageReservation(Request $request)
    {
        // Validate ang request
        $validated = $request->validate([
            'accomodation_id' => 'required|exists:accomodations,accomodation_id',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0', // Changed min to 0 as children can be 0
            'total_guest' =>'required|integer|min:1',
            'reservation_check_in_date' => 'required|date',
            'reservation_check_in' => 'required',
            'reservation_check_out' => 'required',
            'reservation_check_out_date' => 'required|date',
            'activity_id' => 'nullable|array', // Changed to nullable array
            'quantity' => 'required|integer|min:1' // Added validation for quantity
        ]);
    
        try {
            // Kunin ang accommodation details
            $accommodation = Accomodation::findOrFail($request->accomodation_id);
    
            // Calculate total price (assuming price is per unit of quantity)
            $totalPrice = $accommodation->accomodation_price * $request->quantity;
    
            // Calculate total guests
            $totalGuests = $request->number_of_adults + $request->number_of_children;
    
            // Handle activity selection (store as JSON if multiple)
            $activityIds = $request->input('activity_id', []);
            $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);
    
            // I-prepare ang reservation details para sa session
            $reservationDetails = [
                'user_id' => Auth::id(),
                'accomodation_id' => json_encode([$request->accomodation_id]),
                'activity_id' => $selectedActivityId, // Add activity_id to reservation details
                'number_of_adults' => $request->number_of_adults,
                'number_of_children' => $request->number_of_children,
                'total_guest' => $totalGuests,
                'reservation_check_in_date' => $request->reservation_check_in_date,
                'reservation_check_in' => $request->reservation_check_in,
                'reservation_check_out' => $request->reservation_check_out,
                'reservation_check_out_date' => $request->reservation_check_out_date,
                'quantity' => $request->quantity, // Added quantity to session details
                'amount' => $totalPrice
            ];
    
            // I-save sa session ang reservation details
            session(['reservation_details' => $reservationDetails]);
    
            return redirect()->route('paymentProcess')->with('success', 'Reservation saved.Wait for the staff to process your reservation.Thank you!');

        } catch (\Exception $e) {
            Log::error('Reservation save error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error saving reservation.');
        }
    }

public function feedback(Request $request)
{
    try {
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|max:5',
            'comment' => 'required|string|max:500',
            'reservation_id' => 'required|exists:reservation_details,id'
        ]);

        // Find the reservation
        $reservation = Reservation::findOrFail($validated['reservation_id']);

        // Store feedback
        $feedback = $reservation->feedback()->create([
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return redirect()->back()
            ->with('success', 'Thank you for your feedback!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error submitting feedback: ' . $e->getMessage());
    }
}

}
