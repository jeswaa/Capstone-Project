<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\AdminSideController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\SignupController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/* LOGIN */
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
/*Landing page/index */
Route::get('/', [LandingPageController::class, 'index']);
/*homepage page/index */
Route::get('/homepage', [HomePageController::class, 'homepage'])->name('homepage');

// SIGNUP
Route::get('/signup', [SignUpController::class, 'signup'])->name('signup');
Route::post('/signup/store', [SignUpController::class, 'store'])->name('signup.store');

Route::get('/auth/google/redirect',[GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// ADMIN ROUTES
Route::get('/dashboard', [AdminSideController::class, 'dashboard'])->name('dashboard');
Route::get('/reservations', [AdminSideController::class, 'reservations'])->name('reservations');
Route::get('/guests', [AdminSideController::class, 'guests'])->name('guests');
Route::get('/transactions', [AdminSideController::class, 'transactions'])->name('transactions');
Route::get('reports', [AdminSideController::class, 'reports'])->name('reports');
Route::get('/logout', [AdminSideController::class, 'logout'])->name('logout');
