<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Theaters;
use App\Http\Controllers\Admin\ScreensController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\EmailsController;
use App\Http\Controllers\Admin\KindsController;
use App\Http\Controllers\Admin\MoviesController;
use App\Http\Controllers\Admin\ShowtimesController;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('admin')->group(function () {

        Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');

        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/{guard}', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/{guard}', [AdminProfileController::class, 'destroy'])->name('profile.destroy');

        //theaters
        Route::prefix('theaters')->name('theaters.')->group(function () {
            Route::get('/', [Theaters::class, 'index'])->name('index');
            Route::get('/create', [Theaters::class, 'create'])->name('create');
            Route::post('/store', [Theaters::class, 'store'])->name('store');
            Route::get('/{theater}/edit', [Theaters::class, 'edit'])->name('edit');
            Route::put('/{theater}', [Theaters::class, 'update'])->name('update');
            Route::delete('/{theater}', [Theaters::class, 'destroy'])->name('destroy');
            Route::get('/search', [Theaters::class, 'search'])->name('search');
            Route::get('/{theater}/movies', [Theaters::class, 'movies'])->name('movies');
            Route::post('/{theater}/movies/add', [Theaters::class, 'addMovies'])->name('addMovies');
            Route::get('/{theater}/movies/{movie}/delete', [Theaters::class, 'deleteMovies'])->name('deleteMovies');
        });


        //screens
        Route::prefix('theater')->name('screens.')->group(function () {
            Route::get('/{theater}/screens', [ScreensController::class, 'index'])->name('index');
            Route::get('/{theater}/screens/create', [ScreensController::class, 'create'])->name('create');
            Route::post('/theater/screens/store', [ScreensController::class, 'store'])->name('store');
            Route::get('/{theater}/screens/{screen}/edit', [ScreensController::class, 'edit'])->name('edit');
            Route::PUT('/{theater}/screens/{screen}', [ScreensController::class, 'update'])->name('update');
            Route::delete('/{theater}/screens/{screen}', [ScreensController::class, 'destroy'])->name('destroy');
            Route::get('/{theater}/screens/{screen}/show', [ScreensController::class, 'show'])->name('show');
            Route::post('/{theater}/screens/{screen}/fakeSeat', [ScreensController::class, 'fakeSeat'])->name('fakeSeat');
            Route::get('/{theater}/screens/{seat}/realSeat', [ScreensController::class, 'realSeat'])->name('realSeat');
        });

        //showTimes
        Route::prefix('theater')->name('showtimes.')->group(function () {
            Route::get('/{theater}/movies/{movie}/showTimes', [ShowtimesController::class, 'index'])->name('index');
            Route::get('/{theater}/movies/{movie}/showTimes/create', [ShowtimesController::class, 'create'])->name('create');
            Route::post('/{theater}/movies/{movie}/showTimes/store', [ShowtimesController::class, 'store'])->name('store');
            Route::get('/showTimes/{showtime}/edit', [ShowtimesController::class, 'edit'])->name('edit');
            Route::PUT('/showTimes/{showtime}', [ShowtimesController::class, 'update'])->name('update');
            Route::delete('/showTimes/destroy', [ShowtimesController::class, 'destroy'])->name('destroy');
        });

        //categories
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('index');
            Route::get('/create', [CategoriesController::class, 'create'])->name('create');
            Route::post('/store', [CategoriesController::class, 'store'])->name('store');
            Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('edit');
            Route::put('/{category}', [CategoriesController::class, 'update'])->name('update');
            Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('destroy');
            Route::get('/search', [CategoriesController::class, 'search'])->name('search');
            Route::get('/{category}/movies', [CategoriesController::class, 'movies'])->name('movies');
        });

        //kinds
        Route::prefix('kinds')->name('kinds.')->group(function () {
            Route::get('/', [KindsController ::class, 'index'])->name('index');
            Route::get('/create', [KindsController ::class, 'create'])->name('create');
            Route::post('/store', [KindsController ::class, 'store'])->name('store');
            Route::get('/{kind}/edit', [KindsController ::class, 'edit'])->name('edit');
            Route::put('/{kind}', [KindsController ::class, 'update'])->name('update');
            Route::delete('/{kind}', [KindsController ::class, 'destroy'])->name('destroy');
            Route::get('/search', [KindsController ::class, 'search'])->name('search');
            Route::get('/{kind}/movies', [KindsController ::class, 'movies'])->name('movies');
        });
        
        //movies
        Route::prefix('movies')->name('movies.')->group(function () {
            Route::get('/', [MoviesController::class, 'index'])->name('index');
            Route::get('/create', [MoviesController::class, 'create'])->name('create');
            Route::post('/store', [MoviesController::class, 'store'])->name('store');
            Route::get('/{movie}/edit', [MoviesController::class, 'edit'])->name('edit');
            Route::post('/{movie}', [MoviesController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MoviesController::class, 'destroy'])->name('destroy');
            Route::get('/search', [MoviesController::class, 'search'])->name('search');
            Route::get('/{movie}/explore', [MoviesController::class, 'explore'])->name('explore');
            Route::get('/{movie}/unexplore', [MoviesController::class, 'unexplore'])->name('unexplore');
        });

        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [BookingsController::class, 'index'])->name('index');
            Route::get('/{booking}/show', [BookingsController::class, 'show'])->name('show');
            Route::get('/search', [BookingsController::class, 'search'])->name('search');
        });

        Route::post('/email', [EmailsController::class, 'email'])->name('email');

    });

    require __DIR__.'/adminAuth.php';
    
});




