<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\UserController;

// ==========================
// Dashboard chung (tùy role)
// ==========================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ==========================
// Profile người dùng
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// Auth routes (login, register, logout) - KHÔNG có prefix admin
// ==========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// ==========================
// Trang Store (user thường)
// ==========================
Route::get('/store', function () {
    return view('store'); // resources/views/store.blade.php
})->middleware('auth')->name('store');

// ==========================
// Khu vực Admin
// ==========================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', function () {
        return view('dashboard'); // hoặc AdminDashboardController@index
    })->name('dashboard');

    // CRUD users
    Route::resource('users', UserController::class);
});
