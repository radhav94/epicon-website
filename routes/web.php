<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
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

Route::get('test', [TestController::class, 'index']);

Route::get('/', [PageController::class, 'index'])->name('homepage');

Route::get('/{slug}', [PageController::class, 'index']);

Route::post('spinner', [PageController::class, 'getSpinnerContent'])->name('spinner');
