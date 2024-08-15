<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Api\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Api\Auth\NewPasswordController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TheaterController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [HomeController::class, 'main']);
    // Route::get('/user', function (Request $request){ return $request->user(); });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');


    Route::prefix('movies')->name('movies.')->group(function(){
        Route::get('/', [MoviesController::class, 'index'])->name('index');
        Route::get('/Kind/{id}', [MoviesController::class, 'Kind'])->name('Kind');
        Route::get('/top-10-movies', [MoviesController::class, 'top10'])->name('top10');
        Route::get('/search', [MoviesController::class, 'search'])->name('search');
        Route::get('/{movie}', [MoviesController::class, 'show'])->name('show');
    });

    Route::prefix('theaters')->name('theaters.')->group(function(){
        Route::get('/', [TheaterController::class, 'index'])->name('index');
        Route::get('/search', [TheaterController::class, 'search'])->name('search');
        Route::get('/{id}', [TheaterController::class, 'show'])->name('show');
    });

    Route::prefix('bookings')->name('bookings.')->group(function(){
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('myBookings');
        Route::get('redirect', [BookingController::class, 'redirect'])->name('redirect');

        // phase 1
        Route::post('/store', [BookingController::class, 'store'])->name('store');
        Route::get('/show/{id}', [BookingController::class, 'show'])->name('show');
        Route::get('/myBooking/{id}', [BookingController::class, 'myBooking']);
        Route::post('/theater', [BookingController::class, 'theater'])->name('theater');
        Route::post('/date', [BookingController::class, 'date'])->name('date');
        Route::post('/time', [BookingController::class, 'time'])->name('time');

        //phase 2
        Route::post('/store2', [BookingController::class, 'store2'])->name('store2');
        Route::get('/screen/{booking}', [BookingController::class, 'seats'])->name('seats');
        Route::post('/seat/select', [BookingController::class, 'select'])->name('selectSeat');
        Route::post('/seat/unSelect', [BookingController::class, 'unSelect'])->name('unSelectSeat');
        Route::post('/storeSeats', [BookingController::class, 'storeSeats'])->name('storeSeats');
        Route::get('/{booking}/confirm', [BookingController::class, 'confirm'])->name('confirm');
        Route::get('/thanks', [BookingController::class, 'thanks'])->name('thanks');
        Route::post('/destroy', [BookingController::class, 'destroy'])->name('destroy');
        Route::get('/{booking}/show', [BookingController::class, 'show'])->name('show');


        Route::post('/confirm', [BookingController::class, 'confirm'])->name('confirm');
    });
    Route::get('/search/{search}', [HomeController::class, 'search'])->name('search');

});
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/success', [PaymentController::class, 'success'])->name('api.checkout.success');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');
Route::post('/webhook', [PaymentController::class, 'webhook'])->name('checkout.webhook');




Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');

Route::get('/home', [HomeController::class, 'index'])->name('index');
