<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('login-popup', function () {
    return view('epicon.login-popup');
});

// Route::get('login/facebook', '\App\Http\Controllers\Auth\AuthSocialController@redirectToProvider')->name('facebook');

// Route::get('login/facebook/callback', '\App\Http\Controllers\Auth\AuthSocialController@handleProviderCallback')->name('facebook');

