<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\SignUpUser;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        return view('Frontend.Loginpage');
    }

    public function authenticate(Request $request)
    {
        // Validate input fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Store user in session
            Session::put('user', $user->id);
            Session::put('user_email', $user->email);
            
            return redirect()->intended('homepage');
        }

        // Return an error if authentication fails
        if (!$user) {
            return back()->with('errorlogin', 'User with this email does not exist.')->withInput($request->only('email'));
        } elseif (!Hash::check($request->password, $user->password)) {
            return back()->with('errorlogin', 'The provided credentials do not match our records.')->withInput($request->only('email'));
        } else {
            // Successful login, set session and redirect
            Session::put('user', $user->id);
            Session::put('user_email', $user->email);
            return redirect()->intended('homepage')->with('loginsuccess', 'Welcome, ' . $user->name . '!');
        }
    }
}

