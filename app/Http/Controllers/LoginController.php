<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\SendOTP;
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
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (!User::where('email', $request->email)->exists()) {
                        $fail('Email does not exist.');
                    } elseif (!Hash::check($value, User::where('email', $request->email)->first()->password)) {
                        $fail('Password is incorrect.');
                    }
                },
            ],
        ]);

        // Check if email exists in users table
        if (!User::where('email', $request->email)->exists()) {
            return back()->with('invalidLogin', 'Email does not exist.')->withInput($request->only('email'));
        }

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Store user in session
            Session::put('user', $user->id);
            Session::put('user_email', $user->email);
            Session::put('user_name', $user->name);
            Session::put('user_mobile', $user->mobileNo);
            Session::put('user_address', $user->address);

            return redirect()->route('calendar')->with('success', 'Welcome, ' . $user->name . '!');
        }
        return back()->with('errorlogin', 'Invalid email or password.')->withInput($request->only('email'));
    }
    
    public function reset(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.']);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password reset successful! You can now log in.');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}

