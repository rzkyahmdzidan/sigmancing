<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SpotController;
use App\Http\Controllers\Admin\TokoController;
use App\Http\Controllers\Admin\UmpanController;
use App\Http\Controllers\Admin\AdminController;

// Frontend Routes
Route::get('/', function () {
    return view('frontend.welcome');
})->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/spot', [HomeController::class, 'spotIndex'])->name('spot.index');
Route::get('/spot/{spot}', [HomeController::class, 'spotShow'])->name('spot.show'); // Tambahkan ini
Route::get('/toko', [HomeController::class, 'tokoIndex'])->name('toko.index');
Route::get('/umpan', [HomeController::class, 'umpanIndex'])->name('umpan.index');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Spot Management
    Route::prefix('spot')->name('spot.')->group(function () {
        Route::get('/', [SpotController::class, 'adminIndex'])->name('index');
        Route::get('/search', [SpotController::class, 'search'])->name('search');
        Route::post('/', [SpotController::class, 'store'])->name('store');
        Route::get('/{spot}/edit', [SpotController::class, 'edit'])->name('edit');
        Route::put('/{spot}', [SpotController::class, 'update'])->name('update');
        Route::delete('/{spot}', [SpotController::class, 'destroy'])->name('destroy');
        Route::post('/{spot}/toggle-status', [SpotController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Toko Management
    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('/', [TokoController::class, 'index'])->name('index');
        Route::post('/', [TokoController::class, 'store'])->name('store');
        Route::get('/{toko}/edit', [TokoController::class, 'edit'])->name('edit');
        Route::put('/{toko}', [TokoController::class, 'update'])->name('update');
        Route::delete('/{toko}', [TokoController::class, 'destroy'])->name('destroy');
        Route::post('/{toko}/toggle-status', [TokoController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Umpan Management
    Route::prefix('umpan')->name('umpan.')->group(function () {
        Route::get('/', [UmpanController::class, 'index'])->name('index');
        Route::post('/', [UmpanController::class, 'store'])->name('store');
        Route::get('/{umpan}/edit', [UmpanController::class, 'edit'])->name('edit');
        Route::put('/{umpan}', [UmpanController::class, 'update'])->name('update');
        Route::delete('/{umpan}', [UmpanController::class, 'destroy'])->name('destroy');
    });
});
