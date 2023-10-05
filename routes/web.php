<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageDetailController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetroRewindController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SupermixController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

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

Route::get('pages/loadmore', [PageController::class, 'loadMore'])->name('page.loadmore');

// Route::get('explore', [PageController::class, 'explore'])->name('explore');
Route::post('spinner', [PageController::class, 'getSpinnerContent'])->name('spinner');
Route::post('clap', [PageDetailController::class, 'clap'])->name('clap');

// Route::middleware(['loggedin'])->resource('profile', ProfileController::class);

Route::group(['middleware' => 'loggedin', 'as' => 'profile.', 'prefix' => 'profile'], function () {
    Route::get('/manage', [ProfileController::class, 'index'])->name('index');
    Route::get('/add-profile', [ProfileController::class, 'add'])->name('add');
    Route::post('/add-profile', [ProfileController::class, 'store'])->name('store');
    Route::get('/edit-Profile/{id}', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/edit-Profile', [ProfileController::class, 'update'])->name('update');
    Route::post('/delete-Profile/{id}', [ProfileController::class, 'destroy'])->name('destroy');

    Route::post('/setChildPin', [ProfileController::class, 'setChildPin'])->name('setChildPin');

    //Route::get('getSubscription',[SubscriptionController::class,'subscription'])->name('subscription');
});

Route::group(['middleware' => 'loggedin'], function () {
    Route::any('logout', LogoutController::class)->name('logout');
    Route::post('wishlist', [PageController::class, 'wishlist'])->name('wishlist');
    //Subscription routes created by Ram
    Route::post('getCouponAjax', [SubscriptionController::class, 'getCoupon'])->name('getCoupon');
    //end
});

//dynamic / other pages route
Route::post('/retro-content', [RetroRewindController::class, 'retroRewindContent']);

Route::any('/supermix', [SupermixController::class, 'superMix']);

foreach ($lang as $val) {
    $prefix = $val != 'en' ? "/$val" : "";
    $prefix_name = $val != 'en' ? $val . "." : "";

//dynamic pages route
//Route::get('/{slug}', [PageController::class, 'index']);
//Route::get('/{pageslug}/{contentslug}', [PageDetailController::class, 'detail']);

    Route::group(['middleware' => 'loggedin', 'as' => $prefix_name . "profile.", 'prefix' => $prefix . "/profile"], function () {
        Route::get('/manage', [ProfileController::class, 'index'])->name('index');
        Route::get('/add-profile', [ProfileController::class, 'add'])->name('add');
        Route::post('/add-profile', [ProfileController::class, 'store'])->name('store');
        Route::get('/edit-Profile/{id}', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/edit-Profile', [ProfileController::class, 'update'])->name('update');
        Route::post('/delete-Profile/{id}', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/setChildPin', [ProfileController::class, 'setChildPin'])->name('setChildPin');
    });

    Route::group(['middleware' => 'loggedin', 'prefix' => $prefix], function () {
        //Subscription routes created by Ram
        Route::post('paymentMethod', [SubscriptionController::class, 'setSubscription'])->name('paymentMethod');
        Route::post('planBenefit', [SubscriptionController::class, 'planBenefit']);
        Route::post('saveSubscription', [SubscriptionController::class, 'saveSubscription'])->name('saveSubscription');
        Route::get('subscription', [SubscriptionController::class, 'subscription'])->name('subscription');
        Route::post('saveSubscription', [SubscriptionController::class, 'saveSubscription'])->name('saveSubscription');
        Route::post('payusuccess', [SubscriptionController::class, 'payusuccess'])->name('payusuccess');
        Route::post('payufail', [SubscriptionController::class, 'payufail'])->name('payufail');
        Route::post('paymentProcess', [SubscriptionController::class, 'paymentProcess'])->name('paymentProcess');
        Route::post('thankyou', [SubscriptionController::class, 'thankyou'])->name('thankyou');
        //end
    });

    Route::get($prefix . '/kids/{slug?}', [PageController::class, 'kidsIndex'])->name($prefix_name . 'kidsIndex');
    Route::get($prefix . '/', [PageController::class, 'index'])->name($prefix_name . 'homepage');
    Route::get($prefix . '/explore', [PageController::class, 'explore'])->name('explore');
    Route::get($prefix . '/{pageslug}/{contentslug}/{season?}/{episode?}', [PageDetailController::class, 'detail']);
    Route::get($prefix . '/retro-rewind/{slug}', [RetroRewindController::class, 'retroRewindList'])->name('retro-list');
    Route::get($prefix . '/{slug}', [PageController::class, 'index']);
}

Route::post('/player', [PlayerController::class, 'getVideoUrl']);
Route::post('/setplayTracking', [PlayerController::class, 'setplayTracking']);
