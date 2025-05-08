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
    
        if (!$responseData['success']) {
            return back()->withErrors(['recaptcha' => 'reCAPTCHA verification failed.']);
        }
        $credential = $request->input('credential');
        $password = $request->input('password');
    
        if (filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            // Guest login process (with OTP)
            $user = User::where('email', $credential)->first();
            if (!$user) {
                return back()->with('invalidLogin', 'Email does not exist.')->withInput($request->only('credential'));
            }
            if ($user->status === 'banned') {
                return back()->with('errorlogin', 'This account has been banned. Please contact support for assistance.')
                    ->withInput($request->only('credential'));
            }
            // Validate password
            if (empty($password) || !Hash::check($password, $user->password)) {
                return back()->with('errorlogin', 'Invalid email or password.')->withInput($request->only('credential'));
            }
            // Generate OTP and send email
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            session(['login_otp' => $otp, 'login_otp_email' => $credential]);
            try {
                Mail::to($credential)->send(new LoginOTPMail($otp));
                session(['show_otp_modal' => true, 'otp_email' => $credential]);
                return back()->with('success', 'OTP has been sent to your email. Please check your inbox.');
            } catch (\Exception $e) {
                return back()->with('errorlogin', 'Failed to send OTP. Please try again.');
            }
        } else {
            // Check admin credentials first
            $admin = DB::table('admintbl')->where('username', $credential)->first();
            if ($admin) {
                if (empty($password)) {
                    return back()->with('errorlogin', 'Password is required')->withInput($request->only('credential'));
                }

                if ($password === $admin->password) {
                    Session::put('user', $admin->id);
                    Session::put('user_name', $admin->name ?? $admin->username);
                    Session::put('AdminLogin', $admin->id);
                    return redirect()->route('dashboard');
                }
            }

            // If not admin, check staff credentials
            $staff = DB::table('stafftbl')->where('username', $credential)->first();
            if ($staff) {
                if (empty($password)) {
                    return back()->with('errorlogin', 'Password is required')->withInput($request->only('credential'));
                }

                if (Hash::check($password, $staff->password)) {
                    Session::put('user', $staff->id);
                    Session::put('user_name', $staff->name ?? $staff->username);
                    Session::put('StaffLogin', $staff->id);
                    return redirect()->route('staff.dashboard');
                }
            }

            // If neither admin nor staff credentials match
            return back()->with('errorlogin', 'Invalid username or password')->withInput($request->only('credential'));
        }
    }
    protected function attemptLogin(Request $request)
    {
        // Check if user is banned before attempting login
        $user = DB::table('users')->where('email', $request->email)->first();
        
        if ($user && $user->status === 'banned') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'This account has been banned. Please contact support for assistance.']);
        }

        return Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        );
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
        $password = $request->input('password');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }

        // Check if user is banned
        if ($user->status === 'banned') {
            return response()->json([
                'success' => false,
                'message' => 'This account has been banned. Please contact support for assistance.'
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

        // Add success message to flash session
        session()->flash('success', 'OTP verified successfully.');
        
        // Return with success message and redirect
        return redirect()->route('calendar')->with('success', 'Login successful!');
    }
    
    // Return with error message
    return back()->with('error', 'Invalid OTP. Please try again.');
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

