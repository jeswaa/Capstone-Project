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
        return view('Frontend.homepage'); // Ensure 'homepage' matches your blade file name
    }
    public function profilepage()
    {
        $userId = Auth::id();

        // Fetch user details
        $user = DB::table('users')->where('id', $userId)->first();

        $latestReservation = DB::table('reservation_details')
            ->leftJoin('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
            ->leftJoin('activitiestbl', 'reservation_details.activity_id', '=', 'activitiestbl.id')
            ->where('reservation_details.user_id', $userId)
            ->select(
                'reservation_details.*', 
                'packagestbl.package_name', 
                'packagestbl.package_room_type', 
                'packagestbl.package_max_guests',
                'activitiestbl.activity_name',
                'activitiestbl.id as activity_id',
            )
            ->orderByDesc('reservation_details.id')
            ->first();

        // --- Fetch Accommodations ---
        $accommodationIds = json_decode($latestReservation->accomodation_id, true);
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
        
        // Fetch all past reservations except the latest one (check if latestReservation exists)
        $pastReservations = [];
        if ($latestReservation) {
            $pastReservations = DB::table('reservation_details')
                ->join('packagestbl', 'reservation_details.package_id', '=', 'packagestbl.id')
                ->where('reservation_details.user_id', $userId)
                ->where('reservation_details.id', '!=', $latestReservation->id) // Exclude the latest reservation
                ->orderBy('reservation_details.reservation_check_in_date', 'desc')
                ->get();
        }

        return view('Frontend.profilepage', [
            'user' => $user,
            'latestReservation' => $latestReservation,
            'pastReservations' => $pastReservations,
            'accommodations' =>  $accommodations
        ]);
    }


    public function editProfile(Request $request)
    {
        // Debugging: Check if request data is coming through
        // dd($request->all());
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobileNo' => 'required|string|max:15',
            'address' => 'required|string|max:255',
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

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    

}
