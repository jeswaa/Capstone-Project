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
        $request->validate([
            'name' => 'required|string|max:255',
            'mobileNo' => 'required|string|max:15',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $otp = rand(100000, 999999);

        Cache::put('otp_' . $request->email, [
            'otp' => $otp,
            'name' => $request->name,
            'mobileNo' => $request->mobileNo,
            'password' => Hash::make($request->password) // Hash the password before saving
        ], now()->addMinutes(5));

        Mail::to($request->email)->send(new SendOTP($otp));

        return response()->json(['message' => 'OTP sent successfully! Please check your email.']);
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