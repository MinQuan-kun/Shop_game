<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/game/{id}', [HomeController::class, 'show'])->name('game.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/user/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Wallet routes
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/deposit', [App\Http\Controllers\WalletController::class, 'showDepositForm'])->name('wallet.deposit');

    // Test deposit route (Development only)
    Route::post('/wallet/test-deposit', [App\Http\Controllers\WalletController::class, 'testDeposit'])->name('wallet.test.deposit');

    // Cancel transaction
    Route::delete('/wallet/transaction/{id}', [App\Http\Controllers\WalletController::class, 'cancelTransaction'])->name('wallet.transaction.cancel');
    // Payment gateway routes
    Route::post('/payment/paypal/deposit', [App\Http\Controllers\PaymentController::class, 'paypalDeposit'])->name('payment.paypal.deposit');
    Route::get('/payment/paypal/success', [App\Http\Controllers\PaymentController::class, 'paypalSuccess'])->name('payment.paypal.success');
    Route::get('/payment/paypal/cancel', [App\Http\Controllers\PaymentController::class, 'paypalCancel'])->name('payment.paypal.cancel');
    Route::post('/payment/momo/deposit', [App\Http\Controllers\PaymentController::class, 'momoDeposit'])->name('payment.momo.deposit');
    Route::get('/payment/momo/return', [App\Http\Controllers\PaymentController::class, 'momoReturn'])->name('payment.momo.return');

    // Cart routes
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

    // Order routes
    Route::get('/checkout', [App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'myOrders'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/check-owns-game/{gameId}', [App\Http\Controllers\OrderController::class, 'ownsGame'])->name('check.owns.game');
});

// MoMo callback (no auth - verified by signature)
Route::post('/payment/momo/callback', [App\Http\Controllers\PaymentController::class, 'momoCallback'])->name('payment.momo.callback');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::patch('/users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('games', GameController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';

