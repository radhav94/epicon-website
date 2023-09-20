<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageDetailController;
use App\Http\Controllers\SupermixController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LogoutController;

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

Route::get('/', [PageController::class, 'index'])->name('homepage');
Route::get('pages/loadmore', [PageController::class, 'loadMore'])->name('page.loadmore');

Route::get('explore', [PageController::class, 'explore'])->name('explore');
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
});

Route::group(['middleware' => 'loggedin'], function () {
    Route::any('logout', LogoutController::class)->name('logout');
    Route::post('wishlist', [PageController::class, 'wishlist'])->name('wishlist');
});




//dynamic / other pages route
Route::any('/retro-rewind/{slug}', [PageController::class, 'retroRewindList'])->name('retro-list');
Route::any('/supermix', [SupermixController::class, 'superMix']);
Route::get('/kids/{slug?}', [PageController::class, 'kidsIndex'])->name('kidsIndex');
Route::get('/{slug}', [PageController::class, 'index']);
Route::get('/{pageslug}/{contentslug}/{season?}/{episode?}', [PageDetailController::class, 'detail']);
