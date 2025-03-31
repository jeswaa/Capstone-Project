<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Package;
use App\Models\Accomodation;
use App\Models\Transaction;
use App\Models\Reservation;
use DateTime;
use App\Models\PersonalDetails_Reservation;
use App\Models\PackageSelectionReservation;
use App\Models\PaymentProcess; // Import the PaymentProcess model


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

    public function selectPackageCustom()
    {
        $accomodations = DB::table('accomodations')->get();
        $activities = DB::table('activitiestbl')->get();
        $addons = DB::table('addons')->get();
        return view('Reservation.selectPackageCustom', ['accomodations' => $accomodations, 'activities' => $activities, 'addons' => $addons]);
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

        // Retrieve entrance fee
        $entranceFee = Transaction::first()->entrance_fee ?? 0;

        // Compute total entrance fee
        $totalGuests = $reservationDetails['total_guest'] ?? 0;
        $totalEntranceFee = $totalGuests * $entranceFee;

        return view('Reservation.paymentProcess', compact(
            'reservationDetails', 
            'packages', 
            'entranceFee', 
            'totalAccomodationPrice', 
            'totalEntranceFee', 
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
    public function fetchAccomodationData(){
        $accomodations = DB::table('accomodations')->get();
        $activities = DB::table('activitiestbl')->get();
        return view('Reservation.selectPackage', ['accomodations' => $accomodations, 'activities' => $activities]);
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
    
    

    public function fixPackagesSelection(Request $request)
    {
        

        // Validate input data
        $request->validate([
            'selected_packages' => 'required|array|min:1',
            'selected_packages.*' => 'exists:packagestbl,id',
            'reservation_check_in_date' => 'required|date|after_or_equal:today',
            'reservation_check_out_date' => 'required|date|after_or_equal:reservation_check_in_date',
            'reservation_check_in' => 'required|string',
            'reservation_check_out' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Convert selected packages for session storage
        $packageValue = count($request->selected_packages) == 1
            ? $request->selected_packages[0]
            : json_encode($request->selected_packages);

        // Store reservation details in session
        session(['reservation_details' => [
            'user_id' => Auth::id(),
            'package_id' => $packageValue,
            'reservation_check_in_date' => $request->reservation_check_in_date,
            'reservation_check_out_date' => $request->reservation_check_out_date,
            'reservation_check_in' => $request->reservation_check_in,
            'reservation_check_out' => $request->reservation_check_out,
            'amount' => $request->amount,
        ]]);

        return redirect()->route('paymentProcess')->with('success', 'Package selection saved. Proceed to enter personal information.');
    }

    
        public function savePackageSelection(Request $request)
    {
        
        
        // Validate input data
        $request->validate([
            'reservation_check_in_date' => 'required|date|after_or_equal:today',
            'reservation_check_out_date' => 'required|date|after_or_equal:reservation_check_in_date',
            'reservation_check_in' => 'required|date_format:H:i',
            'reservation_check_out' => 'required|date_format:H:i',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_children' => 'required|integer|min:0',
        ]);
        

        // Validate selected accommodations
        $selectedAccommodationIds = $request->input('accomodation_id', []);
        if (empty($selectedAccommodationIds)) {
            return redirect()->back()->with('error', 'Please select at least one accommodation.');
        }

        // Fetch accommodation prices
        $accommodations = DB::table('accomodations')
            ->whereIn('accomodation_id', $selectedAccommodationIds)
            ->get();
        
        $accommodationPrice = (float) $accommodations->sum('accomodation_price');

        // Handle activity selection (store as JSON if multiple)
        $activityIds = $request->input('activity_id', []);
        $selectedActivityId = count($activityIds) > 1 ? json_encode($activityIds) : (count($activityIds) === 1 ? $activityIds[0] : null);

        // Compute entrance fee
        $numAdults = (int) $request->input('number_of_adults', 0);
        $numChildren = (int) $request->input('number_of_children', 0);
        $entranceFee = ($numAdults * 100) + ($numChildren * 50);

        // Compute total price
        $totalPrice = $entranceFee + $accommodationPrice;

        // Store reservation details in session
        session()->put('reservation_details', [
            'user_id' => Auth::id(),
            'accomodation_id' => json_encode($selectedAccommodationIds),
            'activity_id' => $selectedActivityId,
            'rent_as_whole' => $request->input('rent_as_whole'),
            'reservation_check_in' => $request->input('reservation_check_in'),
            'reservation_check_out' => $request->input('reservation_check_out'),
            'reservation_check_in_date' => $request->input('reservation_check_in_date'),
            'reservation_check_out_date' => $request->input('reservation_check_out_date'),
            'special_request' => $request->input('special_request'),
            'total_guest' => $numAdults + $numChildren,
            'number_of_adults' => $numAdults,
            'number_of_children' => $numChildren,
            'amount' => $totalPrice,
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
    
        // Retrieve entrance fee from transactions table
        $entranceFee = Transaction::first()->entrance_fee ?? 0;
    
        // Retrieve package details
        $packages = Package::find($reservationDetails['package_id'] ?? null);
    
        // Check if `accomodation_id` exists before decoding
        $accomodationIds = isset($reservationDetails['accomodation_id']) 
            ? json_decode($reservationDetails['accomodation_id'], true) 
            : [];
    
        // Ensure it's an array
        $accomodationIds = is_array($accomodationIds) ? json_encode($accomodationIds) : json_encode([]);
    
        // Store payment details in session
        $reservationDetails['amount'] = $request->input('amount');
        $reservationDetails['payment_method'] = $request->input('payment_method', 'gcash');
        $reservationDetails['mobileNo'] = $request->input('mobileNo');
        $reservationDetails['upload_payment'] = $request->file('upload_payment')->store('public/payments');
        $reservationDetails['reference_num'] = $request->input('reference_num');
        $reservationDetails['payment_status'] = 'pending';
    
        // Save reservation details to database
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->name = Auth::user()->name;
        $reservation->email = Auth::user()->email;
        $reservation->package_id = $reservationDetails['package_id'] ?? null;
        $reservation->total_guest = $reservationDetails['total_guest'] ?? 0;
        $reservation->number_of_adults = $reservationDetails['number_of_adults'] ?? 0;
        $reservation->number_of_children = $reservationDetails['number_of_children'] ?? 0;
        $reservation->accomodation_id = $accomodationIds; // Now properly handled
        $reservation->activity_id = $reservationDetails['activity_id'] ?? null;
        $reservation->reservation_check_in_date = $reservationDetails['reservation_check_in_date'] ?? null;
        $reservation->reservation_check_out_date = $reservationDetails['reservation_check_out_date'] ?? null;
        $reservation->reservation_check_in = $reservationDetails['reservation_check_in'] ?? null;
        $reservation->reservation_check_out = $reservationDetails['reservation_check_out'] ?? null;
        $reservation->amount = $reservationDetails['amount'];
        $reservation->payment_method = $reservationDetails['payment_method'];
        $reservation->mobileNo = $reservationDetails['mobileNo'];
        $reservation->upload_payment = $reservationDetails['upload_payment'];
        $reservation->reference_num = $reservationDetails['reference_num'];
        $reservation->payment_status = $reservationDetails['payment_status'];
        $reservation->save();
    
        // Clear session after saving to database
        session()->forget('reservation_details');
    
        return redirect()->route('summary')->with([
            'success' => 'Payment details saved and reservation completed successfully.'
        ]);
    }

    public function displayReservationSummary()
    {
        $userId = Auth::user()->id;

        // Fetch latest reservation
        $reservationDetails = DB::table('reservation_details')
        ->leftJoin('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
        ->where('reservation_details.user_id', $userId)
        ->select(
            'reservation_details.*',
            'packagestbl.package_name',
            'packagestbl.package_room_type', // palitan mo ito ng package_room_type
            'packagestbl.package_max_guests',
            'packagestbl.package_activities'
        )
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

        // Fetch all reservations
        $reservations = DB::table('reservation_details')->get();

        // Get Fully Booked Dates (Only when all accommodations are unavailable on that date)
        $fullyBookedDates = DB::table('reservation_details')
            ->select('reservation_check_in_date')
            ->groupBy('reservation_check_in_date')
            ->havingRaw('COUNT(*) >= (SELECT COUNT(*) FROM accomodations)')
            ->pluck('reservation_check_in_date')
            ->toArray();

        $events = [];

        foreach ($reservations as $reservation) {
            // Fetch accommodations
            $accommodationIds = json_decode($reservation->accomodation_id, true);
            $accommodations = DB::table('accomodations')
                ->whereIn('accomodation_id', (array) $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();

            // Fetch activities
            $activityIds = json_decode($reservation->activity_id, true);
            $activities = DB::table('activitiestbl')
                ->whereIn('id', (array) $activityIds)
                ->pluck('activity_name')
                ->toArray();

            // Check if the logged-in user owns this reservation
            $isOwner = (int) $reservation->user_id === (int) $userId;

            // Only add reservation events for the owner
            if ($isOwner) {
                $package = DB::table('packagestbl')->where('id', $reservation->package_id)->first();

                $events[] = [
                    'title' => 'Your Reservation',
                    'start' => \Carbon\Carbon::parse($reservation->reservation_check_in_date)->format('Y-m-d'),
                    'end' => \Carbon\Carbon::parse($reservation->reservation_check_out_date)->format('Y-m-d'),
                    'allDay' => true,
                    'color' => '#97a97c', // Green for the user's reservation
                    'extendedProps' => [
                        'user_id' => (int) $reservation->user_id,
                        'name' => $reservation->name,
                        'check_in' => $reservation->reservation_check_in_date,
                        'check_out' => $reservation->reservation_check_out_date,
                        'room_type' => $package->package_room_type ?? '',
                        'accommodations' => implode(", ", $accommodations),
                        'activities' => implode(", ", $activities),
                        'is_owner' => true,
                    ],
                ];
            }
        }

        // Add Fully Booked events
        foreach ($fullyBookedDates as $date) {
            $events[] = [
                'title' => 'Fully Booked',
                'start' => $date,
                'allDay' => true,
                'color' => '#FF0000', // Red for Fully Booked
                'textColor' => 'white'
            ];
        }

        return view('Reservation.Events_reservation', compact('events', 'userId'));
    }



    public function cancelReservation(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255'
        ]);

        $reservation = Reservation::find($id);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Reservation not found.');
        }

        // Update status to "cancelled" and save the reason
        $reservation->payment_status = 'cancelled';
        $reservation->cancel_reason = $request->cancel_reason;
        $reservation->save();

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



}
