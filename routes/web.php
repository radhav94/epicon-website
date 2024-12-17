<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageDetailController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetroRewindController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupermixController;
use App\Http\Controllers\KidsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\AuthSocialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\RewardsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UpcomingController;
use App\Http\Controllers\PopularController;
use App\Http\Controllers\LiveTvController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AndroidPaymentController;
use App\Http\Controllers\DistroTvController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\MaxDeviceController;
use App\Http\Controllers\PaytmController;
use App\Http\Controllers\PaytmQrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TvActiveController;
use App\Http\Controllers\SpotlightController;


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

Route::get('test', [TestController::class, 'index']);
// server ip testing
// Route::get('serveriptesting123xyz', [NotificationController::class, 'getServerIP']);

Route::get('max-device', [MaxDeviceController::class, 'maxDevice'])->name('max-device');

Route::get('activatetv/{code?}', [TvActiveController::class, 'activate_tv_code']);

//////Start Redirection routes ////////

Route::redirect('watch/tv-shows/{any}', '/', 301);
Route::redirect('watch/amar-chitra-katha/{any}', '/', 301);
Route::redirect('watch/epic-shorts/{any}', '/', 301);
Route::redirect('watch/movies/{any}', '/', 301);
Route::redirect('listen/podcast/{any}', '/', 301);
Route::redirect('play/gamepix/{any}', '/', 301);
Route::redirect('play/gamezop/{any}', '/', 301);
Route::redirect('contact-us', '/', 301);
Route::redirect('listen', 'podcast', 301);
Route::redirect('play', 'games', 301);
Route::redirect('privacy-policy', 'privacy', 301);
Route::redirect('about', 'about-us', 301);
Route::redirect('generatepin', 'settings?status=generatepin', 301);
//////End Redirection routes ////////


Route::any('payu/webhook',[SubscriptionController::class, 'payuWebhook']);

//Start paytm routes
    //paytm qrcode generation
    Route::get('paytmqrgeneration',[PaytmQrController::class, 'getPaytmSubscriptionQr']);
    Route::get('paytmqrstatus',[PaytmQrController::class, 'getPaytmQrPaymentStatus']);

    // Route::get('ccavep/paytm',[PaytmController::class, '_androidPaytmUsingWeb']);
    
    //normal paytm
    // Route::post('paytm/payloadresponse',[PaytmController::class, 'payloadresponse']);
    // Route::get('paytm/payloadresponse',[PaytmController::class, 'payloadresponse']);
//End paytm routes 



Route::get('pages/loadmore', [PageController::class, 'loadMore'])->name('page.loadmore');
Route::get('ajaxStoryData', [PageController::class, 'ajaxStoryData'])->name('ajaxStoryData');
Route::get('story/{short_code}', [PageController::class, 'storyPage'])->name('storyPage');Route::post('spinner', [PageController::class, 'getSpinnerContent'])->name('spinner');
Route::get('clap', [PageDetailController::class, 'clap'])->name('clap');

/*login and registration start */
Route::post('sendotp', [LoginController::class, 'setSendOTP'])->name('sendotp');
Route::post('verifyotp', [LoginController::class, 'setOTPVerification'])->name('verifyotp');
Route::post('register', [LoginController::class, 'setSignUp'])->name('register');
Route::post('loginwithpwd', [LoginController::class, 'setSignin'])->name('loginwithpwd');
Route::post('sendforgototp', [LoginController::class, 'SendForgotOtp'])->name('sendforgototp');
Route::post('verifyforgototp', [LoginController::class, 'setForgotOTPVerification'])->name('verifyforgototp');
Route::post('resetpwdapi', [LoginController::class, 'ResetPasswordVerification'])->name('resetpwdapi');
Route::post('saveGenre', [LoginController::class, 'saveGenreForUser'])->name('saveGenre');
Route::get('getGenre', [LoginController::class, 'getGenreList'])->name('getGenre');
Route::get('emailverification', [LoginController::class, 'emailVerification'])->name('emailverification');
Route::post('setResetPassword', [LoginController::class, 'setResetPassword'])->name('setResetPassword');
/*login and registration end */

Route::get('explorecontent', [PageController::class, 'explorecontent'])->name('explorecontent');
//dynamic / other pages route
Route::post('/retro-content', [RetroRewindController::class, 'retroRewindContent']);
Route::any('/supermix', [SupermixController::class, 'superMix']);
Route::post('paginatecontent', [PageController::class, 'paginatecontent'])->name('paginatecontent');
Route::post('channelpaginatecontent', [PageController::class, 'channelpaginatecontent'])->name('channelpaginatecontent');


// Notifications
Route::get('/notifications', [NotificationController::class, 'getNotifications']);

/*social login start*/
Route::get('login/google', [AuthSocialController::class, 'redirectToProvider'])->name('login.google');
Route::get('login/google/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.google.callback');

Route::get('login/facebook', [AuthSocialController::class, 'redirectToProvider'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.facebook.callback');

Route::get('login/twitter', [AuthSocialController::class, 'redirectToProvider'])->name('login.twitter');
Route::get('login/twitter/callback', [AuthSocialController::class, 'handleProviderCallback'])->name('login.twitter.callback');
/*social login end*/

Route::group(['middleware' => 'checkUserAuthToken'], function () {
    Route::post('save-feedback', [FeedbackController::class, 'saveFeedback'])->name('save-feedback');
    Route::get('terms-of-use', function () {
        return view('static.terms-of-use');
    })->name('terms-of-use');

    Route::get('privacy', function () {
        return view('static.privacy');
    })->name('privacy');
});

Route::group(['middleware' => ['loggedin', 'checkUserAuthToken']], function () {
    Route::any('logout', LogoutController::class)->name('logout');
    Route::get('wishlist', [PageController::class, 'wishlist'])->name('wishlist');
    Route::post('verify-kidsPin', [KidsController::class, 'verifyKidsPin'])->name('verify-kidsPin');

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
    Route::get('deleteSearchHistory', [SettingController::class, 'deleteSearchHistory'])->name('deleteSearchHistory');
    //setting controller routes end

    //Subscription routes created by Ram
    Route::post('getCouponAjax', [SubscriptionController::class, 'getCoupon'])->name('getCoupon');
    Route::post('redeemcoupon', [RewardsController::class, 'RedeemCouponCode'])->name('redeemcoupon');
    Route::post('qwikcilverAjax', [SubscriptionController::class, 'redeemQwikCilver'])->name('qwikcilverAjax');
    //end
});

Route::get('/setplayTracking', [PlayerController::class, 'setplayTracking']);
Route::get('/player', [PlayerController::class, 'getVideoUrl']);


foreach ($lang as $val) {
    $prefix = $val != 'en' ? "/$val" : "";
    $prefix_name = $val != 'en' ? $val . "." : "";

    Route::group(['middleware' => ['loggedin', 'checkUserAuthToken'], 'as' => $prefix_name . "profile.", 'prefix' => $prefix . "/profile"], function () {
        Route::get('/manage', [ProfileController::class, 'index'])->name('index');
        Route::get('/add-profile', [ProfileController::class, 'add'])->name('add');
        Route::post('/add-profile', [ProfileController::class, 'store'])->name('store');
        Route::get('/edit-Profile/{id}', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/edit-Profile', [ProfileController::class, 'update'])->name('update');
        Route::post('/delete-Profile/{id}', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/setChildPin', [ProfileController::class, 'setChildPin'])->name('setChildPin');
        Route::get('my_profile/{id}', [ProfileController::class, 'myProfile'])->name('myProfile');
    });

    Route::group(['prefix' => $prefix, 'middleware' => ['loggedin', 'checkUserAuthToken']], function () {
        //Subscription routes created by Ram
        Route::any('paymentMethod', [SubscriptionController::class, 'setSubscription'])->name('paymentMethod');
        Route::post('planBenefit', [SubscriptionController::class, 'planBenefit']);
        Route::post('saveSubscription', [SubscriptionController::class, 'saveSubscription'])->name('saveSubscription');
        //Route::get('subscription', [SubscriptionController::class, 'subscription'])->name('subscription');
        //Route::post('saveSubscription', [SubscriptionController::class, 'saveSubscription'])->name('saveSubscription');
        Route::post('payusuccess', [SubscriptionController::class, 'payusuccess'])->name('payusuccess');
        Route::post('payufail', [SubscriptionController::class, 'payufail'])->name('payufail');
        Route::post('paymentProcess', [SubscriptionController::class, 'paymentProcess'])->name('paymentProcess');
        Route::get('thankyou', [SubscriptionController::class, 'thankyou'])->name('thankyou');
        Route::get('cancelRecurringPayu', [SubscriptionController::class, 'cancelRecurringPayu'])->name('cancelRecurringPayu');
        Route::post('sendOtpAjax', [SubscriptionController::class, 'sendOtpAjax']);
        Route::post('verifyOtpAjax', [SubscriptionController::class, 'verifyOtpAjax']);
        Route::get('transaction-history', [UserAccountController::class, 'TransactionHistory'])->name('transaction-history');
        Route::post('cancelMembership', [SubscriptionController::class, 'cancelMembership']);
        Route::get('upgrade-plan', [UserAccountController::class, 'upgradePlan'])->name('upgrade-plan');
        //end

        /*settings route*/
        Route::get('settings', [SettingController::class, 'Setting'])->name('settings');
        
        Route::get('library', [LibraryController::class, 'index'])->name('library');
        Route::get('my-account', [UserAccountController::class, 'myaccount'])->name('my-account');
        Route::get('my-rewards', [RewardsController::class, 'MyRewards'])->name('my-rewards');

        /* Kids section start */
        // Static Pages Start
        Route::get('kids/about-us', function () {
            $meta = getMeta('about-us');
            return view('static.about', compact('meta'));
        })->name('kids-about');

        Route::get('kids/terms-of-use', function () {
            return view('static.terms-of-use');
        })->name('kids-terms-of-use');

        Route::get('kids/privacy', function () {
            return view('static.privacy');
        })->name('kids-privacy');

        Route::get('kids/feedback', [FeedbackController::class, 'Feedback'])->name('kids-feedback');
        // Static Pages End
        Route::get('/kids/search', [SearchController::class, 'trendingsearch']);
        Route::get('/kids/midpage/{pageslug}/{catalog}', [PageController::class, 'showmidpagedetail']);
        Route::get('/kids/{pageslug}/{contentslug}/{season?}/{episode?}', [PageDetailController::class, 'detail']);
        /* Kids section end */
    });
    Route::get('subscription', [SubscriptionController::class, 'subscription'])->name('subscription');
    Route::group(['prefix' => $prefix, 'as' => $prefix_name, 'middleware' => 'checkUserAuthToken'], function () {
        Route::get('/', [PageController::class, 'index'])->name('homepage');
        Route::get('/kids/{slug?}', [KidsController::class, 'index'])->name('kidsIndex');
        Route::get('payu/androidtransaction', [AndroidPaymentController::class, 'androidPayuUsingWeb'])->name('androidPayuUsingWeb');
        Route::post('androidPayuresponse', [AndroidPaymentController::class, 'androidPayuresponse'])->name('androidPayuresponse');
        Route::any('payment/success', [AndroidPaymentController::class, 'success'])->name('payment/success');
        Route::any('payment/failure', [AndroidPaymentController::class, 'failure'])->name('payment/failure');
        Route::get('distro-tv', [DistroTvController::class, 'index'])->name('distro-tv');
        Route::get('distro-tv/{id}', [DistroTvController::class, 'distrotvvideo'])->name('distrotvvideo');
        Route::any('distro-tv-search', [DistroTvController::class, 'search'])->name('distro-tv-search');
        Route::post('distro-tv-epg', [DistroTvController::class, 'fetchDistroEpg'])->name('distro-tv-epg');
    });

    Route::group(['prefix' => $prefix, 'middleware' => 'checkUserAuthToken'], function () {
        Route::get('feedback', [FeedbackController::class, 'Feedback'])->name('feedback');
        Route::get('about-us', function () {
            $meta = getMeta('about-us');
            return view('static.about', compact('meta'));
        })->name('about');

        Route::get('explore/{slug}', [PageController::class, 'explore_details']);

        Route::get('live-tv', [LiveTvController::class, 'livetv'])->name('live-tv');
        Route::get('spotlight', [SpotlightController::class, 'index'])->name('spotlight');
        Route::get('coming-soon', [UpcomingController::class, 'UpcomingEpicon'])->name('upcoming-epicon');
        Route::get('new-popular', [PopularController::class, 'NewsPopular'])->name('new-popular');
        Route::get('search', [SearchController::class, 'trendingsearch'])->name('search');
        Route::get('get-search', [SearchController::class, 'search'])->name('get-search');
        // Route::get('midpage/{pageslug}/{catalog}', function ($pageslug, $catalog) {
        //     if ($pageslug != 'live-tv') {
        //         return App::call('\App\Http\Controllers\PageController@showmidpagedetail', ['pageslug' => $pageslug, 'catalog' => $catalog]);
        //     }
        // });

        Route::any('midpage/{pageslug}/{catalog?}', function ($pageslug, $catalog=null) {
            if ($pageslug != 'live-tv') {
                return App::call('\App\Http\Controllers\PageController@showmidpagedetail', ['pageslug' => $pageslug, 'catalog' => $catalog]);
            }
        });

        Route::any('explore/{pageslug}/{catalog?}', function ($pageslug, $catalog = null, $redirect = 'explore') {
            if ($pageslug != 'live-tv') {
                return App::call('\App\Http\Controllers\PageController@showmidpagedetail', ['pageslug' => $pageslug, 'catalog' => $catalog, 'redirect' => $redirect]);
            }
        });

        
        Route::get('channels/{slug}', [PageController::class, 'channelsmidpagedetail']);
        Route::get('explore', [PageController::class, 'explore'])->name('explore');
        Route::get('retro-rewind/{slug}', [RetroRewindController::class, 'retroRewindList'])->name('retro-list');
        Route::get('{pageslug}/{contentslug}/{season?}/{episode?}', [PageDetailController::class, 'detail']);
        Route::get('{slug}', [PageController::class, 'index']);
    });
}

Route::any('/payu/transactioncallback', [SubscriptionController::class, 'payuWebhook']);
Route::any('/payu/cancel-si-recur', [SubscriptionController::class, 'payuCancelRecur']);



/**
 * This is the Final Error Controller 
 * Please Don't make any Controller Below
 * if need To Create Please Create From The Above and Starting Of This Comment
 */
Route::get('{any}', [ErrorController::class,'index'])->where('any', '.*');


