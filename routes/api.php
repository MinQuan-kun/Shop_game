<?php

use App\Http\Controllers\API\AccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('accounts')->group(function () {
    Route::get('/', [AccountController::class, 'index']);       // GET /api/accounts
    Route::get('{id}', [AccountController::class, 'show']);    // GET /api/accounts/{id}
    Route::post('/', [AccountController::class, 'store']);     // POST /api/accounts
    Route::put('{id}', [AccountController::class, 'update']);  // PUT /api/accounts/{id}
    Route::delete('{id}', [AccountController::class, 'destroy']); // DELETE /api/accounts/{id}
});

