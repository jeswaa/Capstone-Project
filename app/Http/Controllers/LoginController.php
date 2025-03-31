<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendOTP;
use App\Models\SignUpUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class LoginController extends Controller
{
    public function login()
    {
        return view('FrontEnd.Loginpage');
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


    public function resetPassword(Request $request)
{
    try {
        \Log::info('Reset Request:', [
            'email' => $request->email,
            'otp_entered' => $request->otp
        ]);

        // Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        // Fetch OTP from the database
        $otpRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp) // Ensure this matches database
            ->first();

        if (!$otpRecord) {
            \Log::warning('OTP mismatch', [
                'email' => $request->email,
                'otp_entered' => $request->otp,
                'expected_otp' => optional($otpRecord)->token
            ]);
            return redirect()->back()->with('error', 'Invalid OTP.');
        }

        // Reset Password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete OTP after use
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Flash success message and redirect to login page
        return redirect()->route('login')->with('success', 'Password reset successfully! You can now log in.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error resetting password. Please try again.');
    }
}

    
    // Send OTP method
    public function sendOTP(Request $request) 
    {
        try {
            // Validate email
            $request->validate(['email' => 'required|email|exists:users,email']);

            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);

            // Store OTP in `password_resets` table
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $otp, 'created_at' => now()]
            );

            // Send OTP to user's email
            Mail::to($request->email)->send(new SendOTP($otp));

            return response()->json(['message' => 'OTP sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error sending OTP'], 500);
        }
    }


}

