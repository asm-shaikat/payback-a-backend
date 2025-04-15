<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\UserController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('services')->group(function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::post('/', [ServiceController::class, 'store']);
    });
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
