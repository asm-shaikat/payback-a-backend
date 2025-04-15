<?php

use App\Http\Controllers\API\Auth\LoginOtpApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\UserController;

// Public routes
Route::post('/send-otp', [LoginOtpApiController::class, 'sendOtp']);
Route::post('/verify-otp', [LoginOtpApiController::class, 'verifyOtp']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {


    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::post('/', [ServiceController::class, 'store']);
    });
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
