<?php

use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TheaterController;
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

Route::get('/', [HomeController::class, 'index'])->name('index');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');
    Route::get('/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');
    Route::post('/webhook', [PaymentController::class, 'webhook'])->name('checkout.webhook');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{guard}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('movies')->name('movies.')->group(function(){
        Route::get('/', [MoviesController::class, 'index'])->name('index');
        Route::get('/search', [MoviesController::class, 'search'])->name('search');
        Route::get('/{movie}', [MoviesController::class, 'show'])->name('show');
    });

    Route::prefix('theaters')->name('theaters.')->group(function(){
        Route::get('/', [TheaterController::class, 'index'])->name('index');
        Route::get('/search', [TheaterController::class, 'search'])->name('search');
        Route::get('/{theater}', [TheaterController::class, 'show'])->name('show');
    });

    Route::prefix('kinds')->name('kinds.')->group(function(){
        Route::get('/{kind}', [MoviesController::class, 'kinds'])->name('show');
    });

    Route::prefix('bookings')->name('bookings.')->group(function(){

        Route::get('/', [BookingsController::class, 'index'])->name('index');
        Route::get('redirect', [BookingsController::class, 'redirect'])->name('redirect');

        // phase 1
        Route::post('/store', [BookingsController::class, 'store'])->name('store');
        Route::get('/create/{booking}/{theater_id?}', [BookingsController::class, 'create'])->name('create');
        Route::post('/theater', [BookingsController::class, 'theater'])->name('theater');
        Route::post('/date', [BookingsController::class, 'date'])->name('date');
        Route::post('/time', [BookingsController::class, 'time'])->name('time');

        //phase 2
        Route::post('/store2', [BookingsController::class, 'store2'])->name('store2');
        Route::get('/{booking}/seats', [BookingsController::class, 'seats'])->name('seats');
        Route::post('/seat/select', [BookingsController::class, 'select'])->name('selectSeat');
        Route::post('/seat/unSelect', [BookingsController::class, 'unSelect'])->name('unSelectSeat');
        Route::post('/storeSeats', [BookingsController::class, 'storeSeats'])->name('storeSeats');
        Route::get('/{booking}/confirm', [BookingsController::class, 'confirm'])->name('confirm');
        Route::get('/thanks', [BookingsController::class, 'thanks'])->name('thanks');
        Route::post('/destroy', [BookingsController::class, 'destroy'])->name('destroy');
        Route::get('/{booking}/show', [BookingsController::class, 'show'])->name('show');

    });

    Route::prefix('stripe')->name('stripe.')->group(function(){
        Route::get('checkout', [PaymentController::class, 'checkout'])->name('checkout');
        Route::get('checkout/success', [PaymentController::class, 'checkoutSuccess'])->name('checkout.success');
    });

    Route::get('/send_email', [HomeController::class, 'send_email'])->name('send_email');

});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
