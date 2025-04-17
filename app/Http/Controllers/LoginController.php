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
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use App\Mail\LoginOTPMail;


class LoginController extends Controller
{
    public function login()
    {
        return view('FrontEnd.Loginpage');
    }

public function authenticate(Request $request)
{
    $recaptchaResponse = $request->input('g-recaptcha-response');
    $secretKey = '6LeAQAgrAAAAALayvy-bvh83aloEH0xtXjQC_gsd';

    // Validate that the reCAPTCHA checkbox was checked
    if (!$recaptchaResponse) {
        return back()->withErrors(['recaptcha' => 'Please check the reCAPTCHA box.']);
    }

    // Send a request to Google to verify the reCAPTCHA response
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => $secretKey,
        'response' => $recaptchaResponse,
    ]);

    $responseData = $response->json();

    if ($responseData['success']) {
        // reCAPTCHA verification passed, continue processing the form
    } else {
        // reCAPTCHA verification failed
        return back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed.']);
    }

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

        return redirect()->route('calendar');
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
    
            // Validate input with proper error messages
            $validated = $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp' => 'required',
                'password' => 'required|min:6|confirmed'
            ], [
                'password.confirmed' => 'The password confirmation does not match.',
                'password.min' => 'Password must be at least 6 characters.',
            ]);
    
            // Fetch OTP from the database
            $otpRecord = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->otp)
                ->first();
    
            if (!$otpRecord) {
                \Log::warning('OTP mismatch', [
                    'email' => $request->email,
                    'otp_entered' => $request->otp
                ]);
                return redirect()->back()->with('error', 'Invalid OTP.');
            }
    
            // Verify password confirmation
            if ($request->password !== $request->password_confirmation) {
                return redirect()->back()->with('error', 'Password confirmation does not match.');
            }
    
            // Reset Password
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
    
            // Delete OTP after use
            DB::table('password_resets')->where('email', $request->email)->delete();
    
            return redirect()->route('login')->with('success', 'Password reset successfully!');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Password reset error: '.$e->getMessage());
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

    public function verifyRecaptcha(Request $request)
    {
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = '6LeAQAgrAAAAALayvy-bvh83aloEH0xtXjQC_gsd';

        // Validate that the reCAPTCHA checkbox was checked
        if (!$recaptchaResponse) {
            return back()->withErrors(['recaptcha' => 'Please check the reCAPTCHA box.']);
        }

        // Send a request to Google to verify the reCAPTCHA response
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
        ]);

        $responseData = $response->json();

        if ($responseData['success']) {
            // reCAPTCHA verification passed, continue processing the form
        } else {
            // reCAPTCHA verification failed
            return back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed.']);
        }
    }
    public function sendLoginOTP(Request $request)
    {

        $email = $request->email;
        $password = $request->input('password'); // Changed to use input() method
        
        // More detailed debug logging
        \Log::info('Login attempt details:', [
            'email' => $email,
            'password_exists' => isset($password),
            'password_empty' => empty($password),
            'request_all' => $request->all() // This will show all data received
        ]);
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }
        
        // Check if password is missing
        if (empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is required.'
            ]);
        }
        
        // Check password match
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password.'
            ]);
        }
        
        // Generate a 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        session(['login_otp' => $otp, 'login_otp_email' => $email]);
        
        try {
            Mail::to($email)->send(new LoginOTPMail($otp));
            return response()->json([
                'success' => true,
                'message' => 'OTP has been successfully sent to your email.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ]);
        }
    }
    public function verifyLoginOTP(Request $request)
    {
        $inputOTP = $request->otp;
        $email = $request->email;
        
        // Check if OTP matches
        if (session('login_otp') == $inputOTP && session('login_otp_email') == $email) {
            // Clear OTP from session
            session()->forget(['login_otp', 'login_otp_email']);
            
            // Log the user in
            $user = User::where('email', $email)->first();
            Auth::login($user);
            // Add success message to flash session for display on calendar page
            session()->flash('login_success', 'Login successful!');
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP. Please try again.'
        ]);
    }
    public function resendOTP(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found with this email.'
                ]);
            }

            // Generate new 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Update OTP in session
            session(['login_otp' => $otp, 'login_otp_email' => $email]);

            // Send new OTP via email
            Mail::to($email)->send(new LoginOTPMail($otp));

            return response()->json([
                'success' => true,
                'message' => 'New OTP has been sent to your email.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend OTP. Please try again.'
            ]);
        }
    }
}

