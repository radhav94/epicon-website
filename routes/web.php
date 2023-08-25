<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PageController;
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

/*Route::get('/', function () {
    return view('pages.homepage');
});
*/
Route::get('test', [TestController::class, 'index']);

Route::get('/', [PageController::class, 'index'])->name('homepage');


// Mobile Number Update Route
// Route::post('/sendotp', [LoginController::class, 'setSendOTP'])->name('sendotp');
// Route::post('/sendotp', '\App\Http\Controllers\Auth\LoginController@setSendOTP')->name('sendotp');