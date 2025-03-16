<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SignUpUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SignUpController extends Controller
{
    public function signup()
    {
        return view('Frontend.signuppage');
    }

    public function store(Request $request)
    {
        try {
            // Validate input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'mobileNo' => 'required|string|max:15',
                'email' => 'required|email|unique:users,email',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'password' => 'required|string|min:8',
            ]);

            if ($request->hasFile('image')) {
                try {
                    $imageName = $request->file('image')->store('images', 'public');
                } catch (\Exception $e) {
                    return back()->withErrors(['image' => 'Error saving image. Please try again.']);
                }
            } else {
                $imageName = null;
            }

            // Create User
            $user = new User();
            $user->name = $validatedData['name'];
            $user->address = $validatedData['address'];
            $user->mobileNo = $validatedData['mobileNo'];
            $user->email = $validatedData['email'];
            $user->image = $imageName;
            $user->password = Hash::make($validatedData['password']);

            // Save the user
            if ($user->save()) {
                return redirect()->route('login')->with('success', 'Account created successfully!');
            } else {
                return back()->withErrors(['error' => 'Failed to create account.']);
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in SignUpController@store: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating your account. Please try again.');
        }
    }


    
}
