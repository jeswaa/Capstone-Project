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
    // Check if the selected reservation date is available
    $checkIn = new DateTime($request->input('reservation_check_in_date'));
    $checkOut = new DateTime($request->input('reservation_check_out_date'));
    
    if (!$this->isDateAvailable($checkIn->format('Y-m-d')) || !$this->isDateAvailable($checkOut->format('Y-m-d'))) {
        return redirect()->back()->with('error', 'The selected reservation date is already taken.');
    }

    // Fetch accommodation price
    $accommodation = DB::table('accomodations')->where('accomodation_id', $request->input('accomodation_id'))->first();
    $accommodationPrice = $accommodation ? $accommodation->accomodation_price : 0;

    // Calculate total guests
    $totalGuests = (int) $request->input('total_guest');

    // Get entrance fee
    $entranceFee = (float) $request->input('entrance_fee');

    // Compute total price
    $totalPrice = ($entranceFee * $totalGuests) + $accommodationPrice;

    // Save reservation details
    $reservationDetails = new Reservation();
    $reservationDetails->user_id = Auth::user()->id;
    $reservationDetails->accomodation_id = $request->input('accomodation_id');
    $reservationDetails->activity_id = $request->input('activity_id');
    $reservationDetails->rent_as_whole = $request->input('rent_as_whole');
    $reservationDetails->reservation_check_in = $request->input('reservation_check_in');
    $reservationDetails->reservation_check_out = $request->input('reservation_check_out');
    $reservationDetails->reservation_check_in_date = new DateTime($request->input('reservation_check_in_date'));
    $reservationDetails->reservation_check_out_date = new DateTime($request->input('reservation_check_out_date'));
    $reservationDetails->special_request = $request->input('special_request');
    $reservationDetails->total_guest = $totalGuests;
    $reservationDetails->number_of_adults = $request->input('number_of_adults');
    $reservationDetails->number_of_children = $request->input('number_of_children');
    $reservationDetails->amount = $totalPrice; // Store computed total price
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

        $reservationDetails->save();

        return redirect()->route('summary')->with([
            'success' => 'Payment details saved successfully.'
        ]);
    }

    return redirect()->route('summary')->with('error', 'No reservation found for this user.');
}

    public function displayReservationSummary()
    {
        // Fetch the latest reservation for the authenticated user
        $reservationDetails = Reservation::where('user_id', Auth::user()->id)
                                        ->latest() // Order by the latest created_at timestamp
                                        ->first(); // Get only the first (latest) record

        // Debugging: Log the results
        \Log::info('Latest Reservation Details:', ['details' => $reservationDetails]);

        // Handle case where no reservations exist
        if (!$reservationDetails) {
            return redirect()->back()->with('error', 'No reservations found.');
        }

        // Set default payment status to pending if not already set
        if (is_null($reservationDetails->payment_status)) {
            $reservationDetails->payment_status = 'pending';
            $reservationDetails->save();
        }

        // Fetch package details related to the reservation
        $packageDetails = DB::table('packagestbl')
                            ->where('id', $reservationDetails->package_id)
                            ->first();

        // Pass the latest reservation and package details to the view
        return view('Reservation.summary', compact('reservationDetails', 'packageDetails'));
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
}