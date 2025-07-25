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
            // First validate the basic input fields
            $request->validate([
                'name' => 'required|string|max:255',
                'mobileNo' => 'required|string|max:11', 
                'email' => 'required|email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Check if email already exists in users table
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return redirect()->back()->withErrors(['email' => 'This email address is already registered. Please use a different email or try logging in.']);
            }

            // Check if OTP was recently sent for this email
            $lastOTPTime = Cache::get('otp_time_' . $request->email);
            if ($lastOTPTime && now()->diffInSeconds($lastOTPTime) < 60) {
                return redirect()->back()->withErrors(['error' => 'Please wait 60 seconds before requesting a new OTP']);
            }

            // Generate OTP
            $otp = rand(100000, 999999);

            // Store OTP data in cache
            Cache::put('otp_' . $request->email, [
                'otp' => $otp,
                'name' => $request->name,
                'mobileNo' => $request->mobileNo,
                'password' => Hash::make($request->password)
            ], now()->addMinutes(5));

            // Store the time when OTP was sent
            Cache::put('otp_time_' . $request->email, now(), now()->addMinutes(5));

            // Send OTP via email
            Mail::to($request->email)->send(new SendOTP($otp));

            return redirect()->back()->with('success', 'OTP sent successfully! Please check your email and enter the verification code.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
            
        } catch (\Exception $e) {
            Log::error('OTP Send Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to send OTP. Please try again later.']);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|digits:6'
            ]);

            $otpData = Cache::get('otp_' . $request->email);

            if (!$otpData || $otpData['otp'] != $request->otp) {
                return redirect()->back()->withErrors(['otp' => 'Invalid or expired OTP']);
            }

            // Clear OTP from cache
            Cache::forget('otp_' . $request->email);
            Cache::forget('otp_time_' . $request->email);

            // Create new user
            User::create([
                'name' => $otpData['name'],
                'mobileNo' => $otpData['mobileNo'],
                'email' => $request->email,
                'password' => $otpData['password'], // Password is already hashed
            ]);        
            
            return redirect()->route('login')->with('success', 'Account created successfully! You can now log in.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
            
        } catch (\Exception $e) {
            Log::error('OTP Verification Error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'OTP verification failed. Please try again.']);
        }
    }
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        
        // Check if email exists in your users table
        $exists = User::where('email', $email)->exists();
        
        return response()->json(['exists' => $exists]);
    }
}