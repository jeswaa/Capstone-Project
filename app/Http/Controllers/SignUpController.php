<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendOTP;

class SignUpController extends Controller
{
    public function signup()
    {
        return view('FrontEnd.signuppage');
    }

    public function sendOTP(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'mobileNo' => 'required|string|max:11', 
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Check if OTP was recently sent for this email
            $lastOTPTime = Cache::get('otp_time_' . $request->email);
            if ($lastOTPTime && now()->diffInSeconds($lastOTPTime) < 60) {
                return response()->json(['error' => 'Please wait 60 seconds before requesting a new OTP'], 429);
            }

            $otp = rand(100000, 999999);

            Cache::put('otp_' . $request->email, [
                'otp' => $otp,
                'name' => $request->name,
                'mobileNo' => $request->mobileNo,
                'password' => Hash::make($request->password)
            ], now()->addMinutes(5));

            // Store the time when OTP was sent
            Cache::put('otp_time_' . $request->email, now(), now()->addMinutes(5));

            Mail::to($request->email)->send(new SendOTP($otp));

            return redirect()->back()->with('success', 'OTP sent successfully! Please check your email.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to send OTP. Please try again later.' . $e->getMessage()]);
        }
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $otpData = Cache::get('otp_' . $request->email);

        if (!$otpData || $otpData['otp'] != $request->otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }

        Cache::forget('otp_' . $request->email);

        User::create([
            'name' => $otpData['name'],
            'mobileNo' => $otpData['mobileNo'],
            'email' => $request->email,
            'password' => $otpData['password'], // Password is already hashed
        ]);        
        return response()->json(['message' => 'OTP verified successfully! You can now log in.']);
        return redirect()->route('login')->with('success', 'Signup successful! You can now log in.');
    }

}