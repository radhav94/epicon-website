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
use App\Http\Controllers\LiveTvController;

$lang = ['hi', 'en'];
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

Route::get('transaction-history', [UserAccountController::class, 'TransactionHistory'])->name('trans-history');

Route::post('redeemcoupon', [RewardsController::class, 'RedeemCouponCode'])->name('redeemcoupon');

Route::post('save-feedback', [FeedbackController::class, 'saveFeedback'])->name('save-feedback');

Route::get('terms-of-use', function () {
    return view('static.terms-of-use');
})->name('terms-of-use');

Route::get('privacy', function () {
    return view('static.privacy');
})->name('privacy');

Route::post('paginatecontent', [PageController::class, 'paginatecontent'])->name('paginatecontent');

// Route::get('{pageslug}/{listcatalog}', function () {
//     return view('static.privacy');
// })->name('privacy');
// Route::get('login/facebook', '\App\Http\Controllers\Auth\AuthSocialController@redirectToProvider')->name('facebook');

// Route::get('login/facebook/callback', '\App\Http\Controllers\Auth\AuthSocialController@handleProviderCallback')->name('facebook');

Route::group(['middleware' => 'loggedin'], function () {
    //setting controller routes start
    Route::post('update-genre', [SettingController::class, 'updateUserGenre'])->name('update-genre');
    Route::post('remove-device', [SettingController::class, 'removeDevice'])->name('remove-device');
    Route::post('set-kidsPin', [SettingController::class, 'setKidsPin'])->name('set-kidsPin');
    Route::post('change-password', [SettingController::class, 'changePassword'])->name('change-password');
    Route::post('delete-account', [SettingController::class, 'deleteAccount'])->name('delete-account');
    Route::post('sendOTP-delete-account', [SettingController::class, 'sendOTPForDeleteAccount'])->name('sendOTP-delete-account');
    Route::post('verifyOTP-delete-account', [SettingController::class, 'verifyOTPForDeleteAccount'])->name('verifyOTP-delete-account');
    Route::post('syncDevice-pin', [SettingController::class, 'syncDevicePin'])->name('syncDevice-pin');
    Route::get('set-language', [SettingController::class, 'setLanguage'])->name('set-language');
    //setting controller routes end
});

Route::get('login/google', [AuthSocialController::class, 'redirectToProvider'])->name('login.google');
Route::get('login/google/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.google.callback');

Route::get('login/facebook', [AuthSocialController::class, 'redirectToProvider'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.facebook.callback');

Route::get('login/twitter', [AuthSocialController::class, 'redirectToProvider'])->name('login.twitter');
Route::get('login/twitter/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.twitter.callback');

Route::post('explorecontent', [PageController::class, 'explorecontent'])->name('explorecontent');

foreach ($lang as $val) {
    $prefix = $val != 'en' ? "/$val" : "";
    $prefix_name = $val != 'en' ? $val . "." : "";
    Route::group(['prefix' => $prefix, 'middleware' => 'loggedin'], function () {
        Route::get('settings', [SettingController::class, 'Setting'])->name('settings');
    });

    Route::get($prefix . '/library', [LibraryController::class, 'index'])->name('library');
    Route::get($prefix . '/my-account', [UserAccountController::class, 'myaccount'])->name('my-account');
    Route::get($prefix . '/my-rewards', [RewardsController::class, 'MyRewards'])->name('my-rewards');
    Route::get($prefix . '/feedback', [FeedbackController::class, 'Feedback'])->name('feedback');
    Route::get($prefix . '/about', function () {
        return view('static.about');
    })->name('about');

    Route::get($prefix . '/explore/{slug}/', function ($slug) {
        return App::call('\App\Http\Controllers\PageController@explore_details', ['slug' => $slug]);
    });

    Route::get($prefix . '/live-tv', [LiveTvController::class, 'livetv'])->name('live-tv');
    Route::get($prefix . '/upcoming-epicon', [UpcomingController::class, 'UpcomingEpicon'])->name('upcoming-epicon');
    Route::get($prefix . '/new-popular', [PopularController::class, 'NewsPopular'])->name('new-popular');
    Route::get($prefix . '/search', [SearchController::class, 'trendingsearch'])->name('search');
    Route::post($prefix . '/get-search', [SearchController::class, 'search'])->name('get-search');
    Route::get($prefix . '/midpage/{pageslug}/{catalog}', function ($pageslug, $catalog) {
        // dd($pageslug);
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
}
