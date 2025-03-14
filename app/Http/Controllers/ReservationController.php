<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Package;
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
    public function selectPackageCustom()
    {
        $accomodations = DB::table('accomodations')->get();
        $activities = DB::table('activitiestbl')->get();
        return view('Reservation.selectPackageCustom', ['accomodations' => $accomodations, 'activities' => $activities]);
    }
    public function paymentProcess()
    {
        $reservationDetails = Reservation::where('user_id', Auth::id())->latest()->first();
        $packages = Package::all();
        $accomodations = DB::table('accomodations')->get();
        $entranceFee = Transaction::first()->entrance_fee ?? 0;
        return view('Reservation.paymentProcess', compact('reservationDetails', 'packages', 'entranceFee', 'accomodations'));
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
    
    public function saveReservationDetails(Request $request) {
        $reservationDetails = Reservation::where('user_id', Auth::user()->id)->latest()->first();
        if ($reservationDetails) {
            $reservationDetails->name = $request->input('name');
            $reservationDetails->email = $request->input('email');
            $reservationDetails->mobileNo = $request->input('mobileNo');
            $reservationDetails->address = $request->input('address');
            $reservationDetails->save();
        }

        return redirect()->route('paymentProcess')->with('success', 'Reservation details saved successfully.');
    }

    public function fixPackagesSelection(Request $request)
    {
        
        // Check if selected dates are available
        if (!$this->isDateAvailable($request->reservation_check_in_date) || 
            !$this->isDateAvailable($request->reservation_check_out_date)) {
            return redirect()->back()->with('error', 'The selected reservation date is already taken.');
        }

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

        // Convert selected packages for database storage
        $packageValue = count($request->selected_packages) == 1
            ? $request->selected_packages[0]
            : json_encode($request->selected_packages);

        // Save reservation
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->package_id = $packageValue;
        $reservation->reservation_check_in_date = $request->reservation_check_in_date;
        $reservation->reservation_check_out_date = $request->reservation_check_out_date;
        $reservation->reservation_check_in = $request->reservation_check_in;
        $reservation->reservation_check_out = $request->reservation_check_out;
        $reservation->amount = $request->amount;

        $reservation->save();

        return redirect()->route('reservation')->with('success', 'Package selection saved successfully.');
    }
    public function savePackageSelection(Request $request)
    {
        // Get selected accommodations (can be multiple)
        $selectedAccommodationIds = $request->input('accomodation_id', []);

        // Fetch accommodation prices
        $accommodationPrice = 0;
        if (!empty($selectedAccommodationIds)) {
            $accommodations = DB::table('accomodations')
                ->whereIn('accomodation_id', $selectedAccommodationIds)
                ->get();

            // Sum all selected accommodation prices
            $accommodationPrice = $accommodations->sum('accomodation_price');
        }

        // Get selected activity (if multiple, store as JSON)
        $activityIds = $request->input('activity_id', []);
        $selectedActivityId = count($activityIds) == 1 ? reset($activityIds) : json_encode($activityIds);

        // Compute entrance fee
        $numAdults = (int) $request->input('number_of_adults', 0);
        $numChildren = (int) $request->input('number_of_children', 0);
        $entranceFee = ($numAdults * 100) + ($numChildren * 50);

        // Compute total price
        $totalPrice = $entranceFee + $accommodationPrice;

        // Save reservation details
        $reservationDetails = new Reservation();
        $reservationDetails->user_id = Auth::user()->id;
        $reservationDetails->accomodation_id = json_encode($selectedAccommodationIds); // Store as JSON array
        $reservationDetails->activity_id = $selectedActivityId; // Store as JSON array if multiple
        $reservationDetails->rent_as_whole = $request->input('rent_as_whole');
        $reservationDetails->reservation_check_in = $request->input('reservation_check_in');
        $reservationDetails->reservation_check_out = $request->input('reservation_check_out');
        $reservationDetails->reservation_check_in_date = new DateTime($request->input('reservation_check_in_date'));
        $reservationDetails->reservation_check_out_date = new DateTime($request->input('reservation_check_out_date'));
        $reservationDetails->special_request = $request->input('special_request');
        $reservationDetails->total_guest = $numAdults + $numChildren;
        $reservationDetails->number_of_adults = $numAdults;
        $reservationDetails->number_of_children = $numChildren;
        $reservationDetails->amount = $totalPrice;
        $reservationDetails->save();

        return redirect()->route('reservation')->with('success', 'Package selection saved successfully.');
    }

    private function isDateAvailable($date)
    {
        return !Reservation::where('reservation_check_in_date', $date)
            ->orWhere('reservation_check_out_date', $date)
            ->exists();
    }


    public function savePaymentProcess(Request $request)
{
    $reservationDetails = Reservation::where('user_id', Auth::user()->id)->latest()->first();

    if ($reservationDetails) {
        // Kunin ang entrance_fee mula sa transactions table
        $entranceFee = Transaction::first()->entrance_fee ?? 0;

        // Kunin ang package details
        $package = Package::find($reservationDetails->package_id);
        

        // I-save ang computed amount sa reservation
        $reservationDetails->amount = $request->input('amount');
        $reservationDetails->payment_method = $request->input('payment_method');
        $reservationDetails->mobileNo = $request->input('mobileNo');
        $reservationDetails->upload_payment = $request->file('upload_payment')->store('public/payments');
        $reservationDetails->reference_num = $request->input('reference_num');
        $reservationDetails->payment_status = 'pending';


        $reservationDetails->save();

        return redirect()->route('summary')->with([
            'success' => 'Payment details saved successfully.'
        ]);
    }

    return redirect()->route('summary')->with('error', 'No reservation found for this user.');
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
            'packagestbl.package_room_type',
            'packagestbl.package_max_guests',
            'packagestbl.package_activities'
        )
        ->latest('reservation_details.created_at') // Get the latest reservation
        ->first(); // Fetch one latest reservation only

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

    // Debugging: Log fetched details
    \Log::info('Reservation Summary:', [
        'reservation' => $reservationDetails,
        'activities' => $activities,
        'accommodations' => $accommodations
    ]);

    return view('Reservation.summary', [
        'reservationDetails' => $reservationDetails,
        'activities' => $activities,
        'accommodations' => $accommodations
    ]);
}


    public function showReservationsInCalendar()
    {
        $events = [];

        $reservations = DB::table('reservation_details')->get();

        $events = $reservations->map(function ($reservation) {
            $package = DB::table('packagestbl')->where('id', $reservation->package_id)->first();
            return [
                'title' => 'Reserved',
                'start' => $reservation->reservation_check_in_date,
                'extendedProps' => [
                    'name' => $reservation->name,
                    'date' => $reservation->reservation_check_in_date,
                    'check_in' => (new DateTime($reservation->reservation_check_in))->format('g:i A'),
                    'check_out' => (new DateTime($reservation->reservation_check_out))->format('g:i A'),
                    'package_room_type' => $package->package_room_type ?? '',
                ],
            ];
        })->toArray();

        $availableDates = DB::table('reservation_details')
            ->selectRaw("distinct reservation_check_in_date as date")
            ->whereNotIn('reservation_check_in_date', array_column($events, 'start'))
            ->get()
            ->map(function ($date) {
                return [
                    'title' => 'Reserve Now',
                    'start' => $date->date,
                    'extendedProps' => [
                        'is_available' => true,
                    ]
                ];
            })
            ->toArray();

        $events = array_merge($events, $availableDates);

        return view('Reservation.Events_reservation', compact('events'));
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

}
