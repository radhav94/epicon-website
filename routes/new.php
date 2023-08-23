<?php

use Illuminate\Support\Facades\Route;


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
Route::post('/sendotp', '\App\Http\Controllers\Auth\LoginController@setSendOTP');