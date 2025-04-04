<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\SignUpUser;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;
class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Check if email already exists
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                // Check if this is a Google account
                if ($existingUser->google_id) {
                    // Existing Google user - proceed with login
                    $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                    $existingUser->update(['otp' => $otp]);
                    Mail::to($existingUser->email)->send(new SendOTP($otp));
                    return redirect()->route('login')->with([
                        'show_otp_modal' => true,
                        'otp_user_id' => $existingUser->id,
                        'otp_email' => $existingUser->email
                    ]);
                } else {
                    // Email exists but not Google account
                    return redirect()->route('login')
                        ->with('error', 'This email is already registered with a different login method.');
                }
            }
            
            // New user - create account
            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(12)),
                'otp' => str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT),
                'otp_expires_at' => now()->addMinutes(5),
            ]);
            
            // Send OTP for new user
            Mail::to($user->email)->send(new SendOTP($user->otp));
            
            return redirect()->route('login')->with([
                'show_otp_modal' => true,
                'otp_user_id' => $user->id,
                'otp_email' => $user->email
            ]);
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Catch duplicate email error
            if ($e->errorInfo[1] == 1062) {
                return redirect()->route('login')
                    ->with('error', 'This email is already registered.');
            }
            throw $e;
        }
    }
    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $user = User::findOrFail($request->user_id);

        if ($user->otp == $request->otp && $user->otp_expires_at > now()) {
            $user->update(['otp' => null]);
            Auth::login($user);
            
            // Redirect to calendar route with success message
            return redirect()->route('calendar')->with('success', 'OTP verified successfully!');
        }

        // Redirect back with error if OTP is invalid
        return back()->with('error', 'Invalid or expired OTP!');
    }
}
