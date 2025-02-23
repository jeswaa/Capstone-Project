<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Reservation;
use DateTime;


class ReservationController extends Controller
{
    public function reservation()
    {
        return view('Reservation.reservation');
    }

    public function selectPackage()
    {
        return view('Reservation.selectPackage');
    }

    public function paymentProcess()
    {
        return view('Reservation.paymentProcess');
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

    
    public function saveReservationDetails(Request $request) {
        $reservationDetails = new Reservation();
        $reservationDetails->user_id = Auth::user()->id;
        $reservationDetails->name = $request->input('name');
        $reservationDetails->email = $request->input('email');
        $reservationDetails->mobileNo = $request->input('mobileNo');
        $reservationDetails->number_of_guests = $request->input('number_of_guests');
        $reservationDetails->address = $request->input('address');


        $reservationDetails->save();

        return redirect()->route('selectPackage')->with('success', 'Reservation details saved successfully.');
    }
    
    public function savePackageSelection(Request $request)
{
    // Check if the selected reservation date is available
    if (!$this->isDateAvailable($request->input('reservation_date'))) {
        return redirect()->back()->with('error', 'The selected reservation date is already taken.');
    }

    // Get the latest reservation for the user
    $reservationDetails = Reservation::where('user_id', Auth::user()->id)->latest()->first();

    if ($reservationDetails) {
        $reservationDetails->room_preference = $request->input('room_preference');
        $reservationDetails->activities = $request->input('activities');
        $reservationDetails->rent_as_whole = $request->input('rent_as_whole');
        $reservationDetails->reservation_date = $request->input('reservation_date');
        $reservationDetails->reservation_check_in = $request->input('reservation_check_in');
        $reservationDetails->reservation_check_out = $request->input('reservation_check_out');
        $reservationDetails->special_request = $request->input('special_request');
        $reservationDetails->save();
    }

    return redirect()->route('paymentProcess');
}

private function isDateAvailable($date)
{
    return !Reservation::where('reservation_date', $date)->exists();
}

    public function savePaymentProcess(Request $request)
    {
        // Get the latest reservation for the user
        $reservationDetails = Reservation::where('user_id', Auth::user()->id)->latest()->first();

        if ($reservationDetails) {
            $reservationDetails->payment_method = $request->input('payment_method');
            $reservationDetails->mobileNo = $request->input('mobileNo');
            $reservationDetails->amount = $request->input('amount');
            $reservationDetails->upload_payment = $request->file('upload_payment')->store('public/payments');
            $reservationDetails->reference_num = $request->input('reference_num');
            $reservationDetails->save();
        }

        return redirect()->route('summary')->with('success', 'Payment details saved successfully.');
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

        // Pass the latest reservation details to the view
        return view('Reservation.summary', compact('reservationDetails'));
    }
    public function showReservationsInCalendar()
    {
        $reservations = DB::table('reservation_details')->get(); // Kunin lahat ng reservations

        $events = [];

        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => 'Reserved',
                'start' => $reservation->reservation_date, // Dapat YYYY-MM-DD format
                'extendedProps' => [
                    'name' => $reservation->name,
                    'date' => $reservation->reservation_date,
                    'check_in' => (new DateTime($reservation->reservation_check_in))->format('g:i A'),
                    'check_out' => (new DateTime($reservation->reservation_check_out))->format('g:i A')
                ]
            ];
        }

        return view('Reservation.Events_reservation', compact('events'));
    }
}