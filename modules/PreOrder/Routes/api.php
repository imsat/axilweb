<?php

use Illuminate\Support\Facades\Route;
use Modules\PreOrder\Http\Controllers\PreOrderController;
use Modules\PreOrder\Http\Controllers\ProductController;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
// Product
    Route::get('products', [ProductController::class, 'index']);

    Route::post('pre-orders', [PreOrderController::class, 'store'])->middleware('throttle:form-submissions');

    Route::middleware('auth:api')->group(function () {

        // Pre order
        Route::get('pre-orders', [PreOrderController::class, 'index']);
        Route::delete('pre-orders/{preOrder}', [PreOrderController::class, 'destroy']);

    });
});

