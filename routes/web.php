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
use App\Http\Controllers\ReservationController;

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

// Reservation
Route::get('/reservation', [ReservationController::class, 'reservation'])->name('reservation');
Route::get('/reservation/select-package', [ReservationController::class, 'selectPackage'])->name('selectPackage');
Route::get('/reservation/payment-process', [ReservationController::class, 'paymentProcess'])->name('paymentProcess');
Route::get('/reservation/summary', [ReservationController::class, 'summary'])->name('Summary');
// Display the credentials of the login user
Route::post('/reservation-personal', [ReservationController::class, 'ReservationDetails'])->name('reservationDetails');
Route::post('/reservation/personal-details', [ReservationController::class, 'savePersonalDetails'])->name('savePersonalDetails');
Route::post('/reservation/select-package-details', [ReservationController::class, 'savePackageSelection'])->name('savePackageSelection');
Route::post('/reservation/save-payment-process', [ReservationController::class, 'savePaymentProcess'])->name('savePaymentProcess');
Route::get('/reservation/display-summary', [ReservationController::class, 'displayReservationSummary'])->name('displayReservationSummary');
Route::get('/reservation/display-packages', [ReservationController::class, 'displayPackageSelection'])->middleware('auth')->name('authenticatedPackages');

// SIGNUP
Route::get('/signup', [SignUpController::class, 'signup'])->name('signup');
Route::post('/signup/store', [SignUpController::class, 'store'])->name('signup.store');

Route::get('/auth/google/redirect',[GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// ADMIN ROUTES
Route::get('/dashboard', [AdminSideController::class, 'dashboard'])->name('dashboard');
Route::get('/reservations', [AdminSideController::class, 'reservations'])->name('reservations');
Route::get('/room-availability', [AdminSideController::class, 'roomAvailability'])->name('roomAvailability');
Route::get('/guests', [AdminSideController::class, 'guests'])->name('guests');
Route::get('/transactions', [AdminSideController::class, 'transactions'])->name('transactions');
Route::get('reports', [AdminSideController::class, 'reports'])->name('reports');
Route::get('/logout', [AdminSideController::class, 'logout'])->name('logout');
