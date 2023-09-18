<?php

use App\Http\Controllers\Auth\AuthSocialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\RewardsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;

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

Route::post('saveGenre', [LoginController::class, 'saveGenreForUser'])->name('saveGenre');

Route::post('getGenre', [LoginController::class, 'getGenreList'])->name('getGenre');
// Route::get('login-popup', function () {
//     return view('epicon.login-popup');
// });

Route::get('library', [LibraryController::class, 'index'])->name('library');

Route::get('my-account', [UserAccountController::class, 'myaccount'])->name('my-account');

Route::get('transaction-history', [UserAccountController::class, 'TransactionHistory'])->name('trans-history');

Route::get('my-rewards', [RewardsController::class, 'MyRewards'])->name('my-rewards');

Route::post('redeemcoupon', [RewardsController::class, 'RedeemCouponCode'])->name('redeemcoupon');

Route::get('feedback', [FeedbackController::class, 'Feedback'])->name('feedback');

Route::post('save-feedback', [FeedbackController::class, 'saveFeedback'])->name('save-feedback');

Route::get('upcoming-epicon', [UpcomingController::class, 'UpcomingEpicon'])->name('upcoming-epicon');

Route::get('new-popular', [PopularController::class, 'NewsPopular'])->name('new-popular');

Route::get('about', function () {
    return view('static.about');
})->name('about');

Route::get('terms-of-use', function () {
    return view('static.terms-of-use');
})->name('terms-of-use');

Route::get('privacy', function () {
    return view('static.privacy');
})->name('privacy');

Route::get('midpage/{pageslug}/{catalog}', function ($pageslug, $catalog) {
    // dd($catalog);
    if ($pageslug != 'live-tv') {
        return App::call('\App\Http\Controllers\PageController@showmidpagedetail', ['pageslug' => $pageslug, 'catalog' => $catalog]);
    }
    // if($pageslug=='tv-shows' || $pageslug=='epic-shorts' || $pageslug=='documentaries' || $pageslug=='live-tv' || $pageslug=='video-books' || $pageslug=='movies' || $pageslug=='amar-chitra-katha'){
    //     return App::call('\App\Http\Controllers\indexController@showdetail', [$displayLanguage,$pageslug,$contentslug,'','']);
    // } else if($pageslug=='podcast'){
    //     return App::call('\App\Http\Controllers\indexController@podcastdetails', [$displayLanguage,$pageslug,$contentslug,'','']);
    // } else if($pageslug=='ebooks'){
    //     $booktitle = $contentslug;
    //     return App::call('\App\Http\Controllers\indexController@showreaddetails', [$displayLanguage,$pageslug,$booktitle,'','']);
    // }
});

Route::post('paginatecontent', [PageController::class, 'paginatecontent'])->name('paginatecontent');

Route::get('trendingsearch', [SearchController::class, 'trendingsearch'])->name('trendingsearch');
Route::post('search', [SearchController::class, 'search'])->name('search');
// Route::get('{pageslug}/{listcatalog}', function () {
//     return view('static.privacy');
// })->name('privacy');
// Route::get('login/facebook', '\App\Http\Controllers\Auth\AuthSocialController@redirectToProvider')->name('facebook');

// Route::get('login/facebook/callback', '\App\Http\Controllers\Auth\AuthSocialController@handleProviderCallback')->name('facebook');

//setting controller routes start
Route::get('settings', [SettingController::class, 'Setting'])->name('settings');
Route::post('update-genre', [SettingController::class, 'updateUserGenre'])->name('update-genre');
Route::post('remove-device', [SettingController::class, 'removeDevice'])->name('remove-device');
Route::post('set-kidsPin', [SettingController::class, 'setKidsPin'])->name('set-kidsPin');
Route::post('change-password', [SettingController::class, 'changePassword'])->name('change-password');
Route::post('delete-account', [SettingController::class, 'deleteAccount'])->name('delete-account');
//setting controller routes end


Route::get('login/google', [AuthSocialController::class, 'redirectToProvider'])->name('login.google');
Route::get('login/google/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.google.callback');

Route::get('login/facebook', [AuthSocialController::class, 'redirectToProvider'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.facebook.callback');

Route::get('login/twitter', [AuthSocialController::class, 'redirectToProvider'])->name('login.twitter');
Route::get('login/twitter/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.twitter.callback');

Route::get('explore/{slug}/', function ($slug) {
    return App::call('\App\Http\Controllers\PageController@explore_details', ['slug'=>$slug]);
});

