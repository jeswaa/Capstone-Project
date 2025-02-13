<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Get the authenticated user's data
        $user = Auth::user();

        // Return the profile page with user data
        return view('Frontend.profilepage', compact('user'));
    }

    public function update(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        // Update the user's information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ]);

        // Redirect back with a success message
        return back()->with('success', 'Profile updated successfully.');
    }
}
