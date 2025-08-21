<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class HomePageController extends Controller
{
    public function homepage()
    {
        return view('FrontEnd.homepage'); // Ensure 'homepage' matches your blade file name
    }
public function profilepage()
{
    $userId = Auth::id();
    if (!$userId) {
        return redirect()->route('login')->with('error', 'Login first to view your profile.');
    }

    // Fetch user details
    $user = DB::table('users')->where('id', $userId)->first();
    if (!$user) {
        return redirect()->route('login')->with('error', 'User not found.');
    }

    $latestReservation = DB::table('reservation_details')
        ->leftJoin('activitiestbl', 'reservation_details.activity_id', '=', 'activitiestbl.id') // Corrected join condition
        ->where('reservation_details.user_id', $userId)
        ->select(
            'reservation_details.*',
            'activitiestbl.activity_name',
            'activitiestbl.id as activity_id',
        )
        ->orderByDesc('reservation_details.id')
        ->first();

    // --- Fetch Accommodations Safely ---
    $accommodations = [];
    if ($latestReservation && $latestReservation->accomodation_id) {
        $accommodationIds = json_decode($latestReservation->accomodation_id, true);

        if (is_array($accommodationIds) && count($accommodationIds) > 0) {
            $accommodations = DB::table('accomodations')
                ->whereIn('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        } elseif (is_numeric($accommodationIds)) {
            $accommodations = DB::table('accomodations')
                ->where('accomodation_id', $accommodationIds)
                ->pluck('accomodation_name')
                ->toArray();
        }
    }

    // Fetch all past reservations except the latest one
    $pastReservations = [];
    if ($latestReservation) {
        $pastReservations = DB::table('reservation_details')
            ->where('reservation_details.user_id', $userId)
            ->where('reservation_details.id', '!=', $latestReservation->id)
            ->orderBy('reservation_details.reservation_check_in_date', 'desc')
            ->get();
    }

    return view('FrontEnd.profilepage', [
        'user' => $user,
        'latestReservation' => $latestReservation,
        'pastReservations' => $pastReservations,
        'accommodations' => $accommodations
    ]);
}


    public function editProfile(Request $request)
    {
        // Debugging: Check if request data is coming through
        // dd($request->all());
    
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'mobileNo' => 'string|max:11',
            'address' => 'string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $user = DB::table('users')->where('id', Auth::id())->first();
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobileNo' => $request->input('mobileNo'),
            'address' => $request->input('address'),
        ];
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
    
            // Store new image
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }
    
        // Update the user's profile
        $updated = DB::table('users')->where('id', Auth::id())->update($data);
    
        if ($updated) {
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'No changes made.');
        }
    }

    public function userlogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear all cookies
        $response = redirect()->route('login')->with('success', 'Logged out successfully!');
        
        // Set cache headers to prevent back button access
        $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
        
        return $response;
    }

    public function getAllReservations()
{
    // Check if user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'You must be logged in to view your reservations. Please login to continue.');
    }

    $userId = Auth::id();
    
    // Double check for user ID (extra safety)
    if (!$userId) {
        Auth::logout(); // Clear any corrupted session
        return redirect()->route('login')->with('error', 'Session expired. Please login again to view your reservations.');
    }

    try {
        // Get the user's information including username
        $user = DB::table('users')->where('id', $userId)->first();
        
        if (!$user) {
            Auth::logout(); // User doesn't exist in database
            return redirect()->route('login')->with('error', 'User account not found. Please login with valid credentials.');
        }
        
        $username = $user->name ?: 'Guest'; // Fallback to 'Guest' if name not found

        // Get the latest reservation ID to exclude
        $latestReservation = DB::table('reservation_details')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->first();

        // Fetch all reservations except the latest one
        $allReservations = DB::table('reservation_details')
            ->leftJoin('activitiestbl', 'reservation_details.activity_id', '=', 'activitiestbl.id')
            ->where('reservation_details.user_id', $userId)
            ->when($latestReservation, function($query) use ($latestReservation) {
                return $query->where('reservation_details.id', '!=', $latestReservation->id);
            })
            ->select(
                'reservation_details.*',
                'activitiestbl.activity_name',
                'activitiestbl.id as activity_id'
            )
            ->orderByDesc('reservation_details.reservation_check_in_date')
            ->get();

        // Process accommodations for each reservation
        foreach ($allReservations as $reservation) {
            $accommodations = [];
            if ($reservation->accomodation_id) {
                $accommodationIds = json_decode($reservation->accomodation_id, true);
                
                if (is_array($accommodationIds) && count($accommodationIds) > 0) {
                    $accommodations = DB::table('accomodations')
                        ->whereIn('accomodation_id', $accommodationIds)
                        ->pluck('accomodation_name')
                        ->toArray();
                } elseif (is_numeric($accommodationIds)) {
                    $accommodations = DB::table('accomodations')
                        ->where('accomodation_id', $accommodationIds)
                        ->pluck('accomodation_name')
                        ->toArray();
                }
            }
            $reservation->accommodations = $accommodations;
        }

        return view('FrontEnd.allReservations', [
            'reservations' => $allReservations,
            'username' => $username
        ]);

    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error in getAllReservations: ' . $e->getMessage());
        
        return redirect()->route('login')->with('error', 'An error occurred while retrieving your reservations. Please try logging in again.');
    }
}

    

}
