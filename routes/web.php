<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// 🔹 Trang store (người dùng bình thường)
Route::get('/store', function () {
    return view('store'); 
})->middleware('auth')->name('store');

// 🔹 Import các route admin riêng (quản trị viên)
require __DIR__ . '/admin.php';
