<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\RewardsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\PopularController;

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

//Profile routes
Route::get('/profile/add', '\App\Http\Controllers\UserAccountController@addprofile')->name('addprofile');

Route::get('/profile/edit', '\App\Http\Controllers\UserAccountController@editprofile')->name('editprofile');

Route::get('/profile/manage', '\App\Http\Controllers\UserAccountController@manageprofile')->name('manageprofile');

// Mobile Number Update Route
Route::post('sendotp', [LoginController::class, 'setSendOTP'])->name('sendotp');

Route::post('verifyotp', [LoginController::class, 'setOTPVerification'])->name('verifyotp');

Route::post('register', [LoginController::class, 'setSignUp'])->name('register');

Route::post('loginwithpwd', [LoginController::class, 'setSignin'])->name('loginwithpwd');

Route::post('sendforgototp', [LoginController::class, 'SendForgotOtp'])->name('sendforgototp');

Route::post('verifyforgototp', [LoginController::class, 'setForgotOTPVerification'])->name('verifyforgototp');

Route::post('resetpwdapi', [LoginController::class, 'ResetPasswordVerification'])->name('resetpwdapi');

// Route::get('login-popup', function () {
//     return view('epicon.login-popup');
// });

Route::get('library', [LibraryController::class, 'index'])->name('library');

Route::get('my-account', [UserAccountController::class, 'myaccount'])->name('my-account');

Route::get('transaction-history', [UserAccountController::class, 'TransactionHistory'])->name('trans-history');

Route::get('my-rewards', [RewardsController::class, 'MyRewards'])->name('my-rewards');

Route::post('redeemcoupon', [RewardsController::class, 'RedeemCouponCode'])->name('redeemcoupon');

Route::get('settings', [SettingController::class, 'Setting'])->name('settings');

Route::get('feedback', [FeedbackController::class, 'Feedback'])->name('feedback');

Route::get('upcoming-epicon', [UpcomingController::class, 'UpcomingEpicon'])->name('upcoming-epicon');

Route::get('new-popular', [PopularController::class, 'Popular'])->name('new-popular');

Route::get('about', function () {
    return view('static.about');
})->name('about');

Route::get('terms-of-use', function () {
    return view('static.terms-of-use');
})->name('terms-of-use');

Route::get('privacy', function () {
    return view('static.privacy');
})->name('privacy');

// Route::get('login/facebook', '\App\Http\Controllers\Auth\AuthSocialController@redirectToProvider')->name('facebook');

// Route::get('login/facebook/callback', '\App\Http\Controllers\Auth\AuthSocialController@handleProviderCallback')->name('facebook');

