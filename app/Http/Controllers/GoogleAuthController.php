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
            
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiresAt = now()->addMinutes(5);

            \DB::beginTransaction();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'google_id' => $googleUser->id,
                    'name' => $googleUser->name,
                    'password' => bcrypt(Str::random(12)),
                    'otp' => $otp,
                    'otp_expires_at' => $expiresAt
                ]
            );

            // Check if the user is banned before sending OTP
            if ($user->status === 'banned') {
                // Optionally clear the generated OTP if it was set during updateOrCreate
                $user->update(['otp' => null, 'otp_expires_at' => null]);
                return redirect()->route('login')->with('error', 'Your account has been banned.');
            }

            Mail::to($user->email)->send(new SendOTP($otp));

            \DB::commit();

            return redirect()->route('login')->with([
                'show_otp_modal' => true,
                'otp_user_id' => $user->id,
                'otp_email' => $user->email,
                'success' => 'OTP sent to your email!'
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Google Auth Error: '.$e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Authentication failed. Please try again.');
        }
    }
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'user_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->user_id);

        \Log::debug('OTP Verification', [
            'Server Time' => now(),
            'DB Time' => \DB::select('SELECT NOW() as now')[0]->now,
            'OTP Expires' => $user->otp_expires_at
        ]);

        if (!$user->otp || $user->otp !== $request->otp) {
            return back()->with('error', 'Invalid OTP code!');
        }

        if (now()->gt($user->otp_expires_at)) {
            return back()->with('error', 'OTP has expired!');
        }

        // Add this check for banned status
        if ($user->status === 'banned') {
            $user->update(['otp' => null, 'otp_expires_at' => null]); // Clear OTP even if banned
            Auth::logout(); // Ensure no previous session persists
            return redirect()->route('login')->with('error', 'Your account has been banned.');
        }

        $user->update(['otp' => null, 'otp_expires_at' => null]);
        Auth::login($user);
        
        // Check if address or mobile number is missing
        if (empty($user->address) || empty($user->mobileNo)) {
            return redirect()->route('profile')->with('info', 'Please complete your profile information.');
        } else {
            return redirect()->route('homepage')->with('success', 'Welcome ' . $user->name . '!');
        }
    }
}

