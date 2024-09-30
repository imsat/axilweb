<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Modules\PreOrder\Http\Controllers\PreOrderController;
use Modules\PreOrder\Http\Controllers\ProductController;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);
});
