<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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