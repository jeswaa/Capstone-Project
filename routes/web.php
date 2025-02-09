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
/*Landing page/index */
Route::get('/landingpage', [LandingPageController::class, 'index']);
/*homepage page/index */
Route::get('/homepage', [HomePageController::class, 'index']);

Route::get('/auth/google/redirect',[GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);


Route::get('/dashboard', [AdminSideController::class, 'dashboard'])->name('dashboard');
