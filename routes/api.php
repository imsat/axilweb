<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);

    // Product
    Route::get('products', [ProductController::class, 'index']);

    Route::post('pre-orders', [PreOrderController::class, 'store'])->middleware('throttle:form-submissions');

    Route::middleware('auth:api')->group(function () {

        // Pre order
        Route::get('pre-orders', [PreOrderController::class, 'index']);
        Route::delete('pre-orders/{preOrder}', [PreOrderController::class, 'destroy']);

    });
});
