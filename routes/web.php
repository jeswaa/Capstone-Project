<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Str;
use App\Http\Controllers\AdminSideController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Admin\RoomController;

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
// Admin Login
Route::get('/login/admin', [AdminSideController::class, 'AdminLogin'])->name('AdminLogin');
Route::post('/login/admin/authenticate', [AdminSideController::class, 'login'])->name('authenticate');

// Apply middleware to admin-specific routes only
Route::middleware(['isAdmin'])->group(function () {
    // ADMIN ROUTES
    Route::get('/admin/dashboard', [AdminSideController::class, 'DashboardView'])->name('dashboard');
    Route::get('/reservations', [AdminSideController::class, 'reservations'])->name('reservations');
    Route::get('/get-bookings', [AdminSideController::class, 'DashboardView']);
    Route::get('/room-availability', [AdminSideController::class, 'roomAvailability'])->name('roomAvailability');
    Route::get('/addons', [AdminSideController::class, 'addons'])->name('addOns');
    Route::post('/store-addons', [AdminSideController::class, 'storeAddOns'])->name('storeAddOns');
    Route::put('/edit-addons/{id}', [AdminSideController::class, 'editAddOn'])->name('editAddOn');
    Route::delete('/addons/delete/{id}', [AdminSideController::class, 'deleteAddOn'])->name('deleteAddOn');
    Route::post('add-room', [AdminSideController::class, 'addRoom'])->name('addRoom');
    Route::put('/rooms/update/{id}', [AdminSideController::class, 'updateRoom'])->name('updateRoom');
    Route::delete('/rooms/delete/{id}', [AdminSideController::class, 'deleteRoom'])->name('deleteRoom');
    Route::get('/rooms-display', [AdminSideController::class, 'DisplayAccomodations'])->name('rooms');
    Route::get('/packages', [AdminSideController::class, 'packages'])->name('packages');
    Route::post('/add-packages', [AdminSideController::class, 'addPackages'])->name('addPackage');
    Route::put('/packages/update/{id}', [AdminSideController::class, 'updatePackage'])->name('updatePackage');
    Route::delete('/packages/delete/{id}', [AdminSideController::class, 'deletePackage'])->name('deletePackage');
    Route::get('/add-activities', [AdminSideController::class, 'Activities'])->name('addActivities');
    Route::post('/store-activities', [AdminSideController::class, 'storeActivity'])->name('storeActivity');
    Route::put('/activities/update/{id}', [AdminSideController::class, 'updateActivity'])->name('updateActivity');
    Route::get('/guests', [AdminSideController::class, 'guests'])->name('guests');
    Route::get('/transactions', [AdminSideController::class, 'editPrice'])->name('transactions');
    Route::post('/transactions/update-entrance-fee', [AdminSideController::class, 'updatePrice'])->name('updatePrice');
    Route::get('reports', [AdminSideController::class, 'reports'])->name('reports');
    Route::get('/admin/settings', [AdminSideController::class, 'showForm'])->name('admin.settings');
    Route::post('/admin/settings/update', [AdminSideController::class, 'updateEmail'])->name('admin.settings.update');
    Route::get('/logout', [AdminSideController::class, 'logout'])->name('logout');
});
Route::get('/admin/update-rooms', [RoomController::class, 'updateRoomAvailability'])->name('admin.update.rooms');

/* LOGIN */
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/verify-recaptcha', [LoginController::class, 'verifyRecaptcha'])->name('login.verifyRecaptcha');

Route::post('/login/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/forgot/otp', [LoginController::class, 'sendOtp'])->name('forgot.sendOTP');
Route::post('/forgot/reset', [LoginController::class, 'resetPassword'])->name('forgot.reset');


// SIGNUP
Route::get('/signup', [SignUpController::class, 'signup'])->name('signup');
Route::post('/signup/send-otp', [SignUpController::class, 'sendOTP'])->name('signup.sendOTP');
Route::post('/signup/verify-otp', [SignUpController::class, 'verifyOTP'])->name('signup.verifyOTP');
/*Landing page/index */
Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');


Route::get('/profile', [HomePageController::class, 'profilepage'])->name('profile');
Route::get('/profile/edit', [HomePageController::class, 'editProfile'])->name('editProfile');
Route::post('/profile/edit', [HomePageController::class, 'editProfile'])->name('editProfile.post');
Route::post('/reservation/cancel/{id}', [ReservationController::class, 'guestcancelReservation'])->name('guestcancelReservation');
Route::get('/reservation-summary/{id}', [ReservationController::class, 'displayReservationSummary'])->name('displaySummary');
//qr code
Route::get('/reservation-summary/{id}', [ReservationController::class,'reservationSummary'])->name('reservation.summary');
Route::get('/user-logout', [HomePageController::class, 'userlogout'])->name('logout.user');
// Reservation
Route::get('/reservation/calendar', [ReservationController::class, 'showReservationsInCalendar'])->name('calendar');
Route::get('/get-available-accommodations', [ReservationController::class, 'getAvailableAccommodations'])->name('getAvailableAccommodations');
Route::get('/reservation', [ReservationController::class, 'reservation'])->name('reservation');
Route::get('/reservation/fetch-accomodation-data', [ReservationController::class, 'fetchAccomodationData'])->name('selectPackage');
Route::get('/reservation/select-package-custom', [ReservationController::class, 'selectPackageCustom'])->name('selectPackageCustom');
Route::get('/reservation/fetch-addons', [ReservationController::class, 'fetchAddons'])->name('fetchAddons');
Route::get('/reservation/payment-process', [ReservationController::class, 'paymentProcess'])->name('paymentProcess');
Route::get('/reservation/display-summary', [ReservationController::class, 'displayReservationSummary'])->name('summary');

// Display the credentials of the login user
Route::post('/reservation-personal', [ReservationController::class, 'fetchUserData'])->name('fetchUserData');
Route::post('/reservation/personal-details', [ReservationController::class, 'saveReservationDetails'])->name('saveReservationDetails');
Route::post('/reservation/select-package-details', [ReservationController::class, 'StayInPackages'])->name('savePackageSelection');
Route::post('/reservation/select-fix-package-details', [ReservationController::class, 'OnedayStay'])->name('fixPackagesSelection');
Route::post('/reservation/save-payment-process', [ReservationController::class, 'savePaymentProcess'])->name('savePaymentProcess');
Route::get('/reservation/display-packages', [ReservationController::class, 'displayPackageSelection'])->name('authenticatedPackages');
// Route for testing file access
Route::get('/payment-proof/{filename}', function ($filename) {
    $path = storage_path('app/public/payments/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('payment.proof');
// API
Route::get('/get-reservations', function () {
    $reservations = Reservation::select('name', 'reservation_date', 'reservation_time')->get();

    $events = $reservations->map(function ($reservation) {
        return [
            'title' => $reservation->name,
            'start' => $reservation->reservation_date . 'T' . $reservation->reservation_time,
            'extendedProps' => [
                'reservation_time' => $reservation->reservation_time
            ]
        ];
    });

    return response()->json($events);
});


//Google Auth
Route::get('/auth/google/redirect',[GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);
Route::post('/verify-otp', [GoogleAuthController::class, 'verifyOTP'])->name('verifyOTP');


// Admin Login
Route::get('/login/admin', [AdminSideController::class, 'AdminLogin'])->name('AdminLogin');
Route::post('/login/admin/authenticate', [AdminSideController::class, 'login'])->name('authenticate');

//Staff Routes
Route::get('/login/staff', [StaffController::class, 'StaffLogin'])->name('staff.login');
Route::post('/login/staff/authenticate', [StaffController::class, 'authenticate'])->name('staff.authenticate');
Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
Route::get('/staff/reservation-details', [StaffController::class, 'reservations'])->name('staff.reservation');
Route::get('/staff/accomodations', [StaffController::class, 'accomodations'])->name('staff.accomodations');
Route::put('/staff/edit-room/{id}', [StaffController::class, 'editRoom'])->name('staff.editRoom');
Route::post('/staff/book-room', [StaffController::class, 'bookRoom'])->name('staff.bookRoom');
Route::post('/staff/cancel-reservation/{id}', [StaffController::class, 'cancelReservation'])->name('staff.cancelReservation');
Route::get('/staff/check-new-reservations', [StaffController::class, 'checkNewReservations']);
Route::post('/staff/transactions/update-payment-status/{id}', [StaffController::class, 'UpdateStatus'])->name('staff.updateStatus');
Route::get('/staff/transactions', [StaffController::class, 'transactions'])->name('staff.transactions');
Route::post('/staff/send-email', [StaffController::class, 'sendEmail'])->name('staff.sendEmail');
Route::get('/staff/guests', [StaffController::class, 'guests'])->name('staff.guests');
Route::get('/staff/logout', [StaffController::class, 'logout'])->name('staff.logout');




