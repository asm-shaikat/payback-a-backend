<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoginOtpController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SiteSettingsController;
use App\Http\Controllers\API\TestController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/test', [TestController::class, 'TestFunc']);

Route::post('/send-otp', [LoginOtpController::class, 'sendOtp']);
Route::post('/verify-otp', [LoginOtpController::class, 'verifyOtp']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {


    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::post('/', [ServiceController::class, 'store']);
    });

    Route::get('/site-settings', [SiteSettingsController::class, 'index']);
    Route::get('/settings/options', [SiteSettingsController::class, 'getDropdownOptions']);
    Route::get('/services/by-email', [ServiceController::class, 'getByEmail']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
