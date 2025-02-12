<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\SignUpUser;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
    
        $user = User::updateOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => $user->password ?? bcrypt(Str::random(12)),
                'email_verified_at' => now(),
            ]
        );
    
        Auth::login($user);
    
        return redirect('homepage')->with('success', 'Logged in successfully!');
    }
    
}
