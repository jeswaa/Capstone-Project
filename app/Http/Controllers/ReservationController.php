<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Reservation;
use DateTime;

use App\Models\User;
use App\Models\PersonalDetails_Reservation;
use App\Models\PackageSelectionReservation;
use App\Models\PaymentProcess; // Import the PaymentProcess model

class ReservationController extends Controller
{
    public function reservation()
    {
        return view('Reservation.reservation');
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

    
    public function fetchAccomodationData(){
        $accomodations = DB::table('accomodations')->get();
        return view('Reservation.selectPackage', ['accomodations' => $accomodations]);
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
        // Validate incoming request data
        $request->validate([
            'selected_packages' => 'required|array', // Ensures at least one package is selected
            'selected_packages.*' => 'exists:packagestbl,id', // Ensures all selected packages exist in the packages table
            'reservation_check_in_date' => 'required|date|after_or_equal:today',
            'reservation_check_out_date' => 'required|date|after:reservation_check_in_date',
            'reservation_check_in' => 'required|string',
            'reservation_check_out' => 'required|string',
        ]);

        // Convert selected packages into a JSON string if multiple packages are allowed
        $selectedPackages = count($request->input('selected_packages')) > 1 
            ? json_encode($request->input('selected_packages')) 
            : $request->input('selected_packages')[0];

        // Check if the selected dates are available
        if (!$this->isDateAvailable($request->reservation_check_in_date) || 
            !$this->isDateAvailable($request->reservation_check_out_date)) {
            return redirect()->back()->with('error', 'The selected reservation date is already taken.');
        }

        // Save reservation details
        $reservationDetails = new Reservation();
        $reservationDetails->user_id = Auth::id(); // Uses Auth::id() to avoid null issues
        $reservationDetails->package_id = $selectedPackages; // Store package_id or JSON for multiple packages
        $reservationDetails->reservation_check_in_date = $request->reservation_check_in_date;
        $reservationDetails->reservation_check_out_date = $request->reservation_check_out_date;
        $reservationDetails->reservation_check_in = $request->reservation_check_in;
        $reservationDetails->reservation_check_out = $request->reservation_check_out;
        $reservationDetails->save();

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

        $reservationDetails = new Reservation();
        $reservationDetails->user_id = Auth::user()->id;
        $reservationDetails->room_preference = $request->input('room_preference');
        $reservationDetails->activities = $request->input('activities');
        $reservationDetails->rent_as_whole = $request->input('rent_as_whole');
        $reservationDetails->reservation_date = $request->input('reservation_date');
        $reservationDetails->reservation_check_in = $request->input('reservation_check_in');
        $reservationDetails->reservation_check_out = $request->input('reservation_check_out');
        $reservationDetails->reservation_check_in_date = new DateTime($request->input('reservation_check_in_date'));
        $reservationDetails->reservation_check_out_date = new DateTime($request->input('reservation_check_out_date'));
        $reservationDetails->special_request = $request->input('special_request');
        $reservationDetails->total_guest = $request->input('total_guest');
        $reservationDetails->number_of_adults = $request->input('number_of_adults');
        $reservationDetails->number_of_children = $request->input('number_of_children');
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
                'start' => $reservation->reservation_check_in_date, // Dapat YYYY-MM-DD format
                'extendedProps' => [
                    'name' => $reservation->name,
                    'date' => $reservation->reservation_check_in_date,
                    'check_in' => (new DateTime($reservation->reservation_check_in))->format('g:i A'),
                    'check_out' => (new DateTime($reservation->reservation_check_out))->format('g:i A')
                ]
            ];
        }

        return view('Reservation.Events_reservation', compact('events'));
    }
}
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

    public function reservationDetails()
    {
        $user = User::find(Auth::id());
        if ($user) {
            $personalDetails = $user->personalDetails;
            return view('reservation', compact('user', 'personalDetails'));
        } else {
            return redirect()->route('login')->with('error', 'User not found.');
        }
    }
    public function savePersonalDetails(Request $request)
    {
        $validated = $request->validate([
            'number_of_guests' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $user->personalDetails()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'mobileNo' => $user->mobileNo,
                'address' => $user->address,
                'number_of_guests' => $validated['number_of_guests'],
            ]
        );

        return redirect()->route('selectPackage');
    }

    public function savePackageSelection(Request $request)
    {
        $validated = $request->validate([
            'rent_as_whole' => 'required|string|max:255',
            'room_preference' => 'required|string|max:255',
            'activities' => 'nullable|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'special_request' => 'nullable|string|max:255',
        ]);

        $personalDetails = PersonalDetails_Reservation::where('user_id', Auth::user()->id)->first();
        

        $packageSelection = PackageSelectionReservation::create([
            'personal_details_id' => $personalDetails->id,
            'rent_as_whole' => $validated['rent_as_whole'],
            'room_preference' => $validated['room_preference'],
            'activities' => $validated['activities'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'special_request' => $validated['special_request'],
        ]);

        return redirect()->route('paymentProcess');
    }
    public function savePaymentProcess(Request $request)
    {  
        $validated = $request->validate([
            'payment_method' => 'required|string|max:255',
            'mobile_num' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'upload_payment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'reference_num' => 'nullable|string|max:255',
        ]);

        $personalDetails = PersonalDetails_Reservation::where('user_id', Auth::user()->id)->first();
        $packageSelection = PackageSelectionReservation::where('personal_details_id', $personalDetails->id)->first();

        if ($request->hasFile('upload_payment')) {
            $image = $request->file('upload_payment');
            $name = $image->getClientOriginalName();
            $destinationPath = 'uploads/payment-proof/';
            $image->move($destinationPath, $name);

            $paymentProcess = PaymentProcess::create([
                'reservation_id' => $packageSelection->reservation_id,
                'payment_method' => $validated['payment_method'],
                'mobile_num' => $validated['mobile_num'],
                'amount' => $validated['amount'],
                'upload_payment' => $name,
                'reference_num' => $validated['reference_num'],
            ]);
        } else {
            $paymentProcess = PaymentProcess::create([
                'reservation_id' => $packageSelection->reservation_id,
                'payment_method' => $validated['payment_method'],
                'mobile_num' => $validated['mobile_num'],
                'amount' => $validated['amount'],
                'reference_num' => $validated['reference_num'],
            ]);
        }
            return redirect()->route('Summary');
    }

    
    public function displayReservationSummary()
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
    
        // Fetch personal details
        $personalDetails = PersonalDetails_Reservation::where('user_id', Auth::id())->first();
        if (!$personalDetails) {
            return redirect()->back()->with('error', 'Personal details not found.');
        }
    
        // Debugging: Check $personalDetails
        dd($personalDetails);    
        // Pass data to the view
        return view('Reservation.summary', compact('personalDetails'));
    }  
    
    public function displayPackageSelection()
{
    // Ensure user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in.');
    }

    // Fetch package selections for the authenticated user
    $packages = PackageSelectionReservation::where('personal_details_id', Auth::id())->get();

    // Pass data to the view
    return view('Reservation.summary', compact('packages'));
}
     

    
}