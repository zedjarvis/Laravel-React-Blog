<?php

use App\Http\Controllers\Api\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// Guest Auth Routes
Route::post('auth/register', [AuthenticationController::class, 'register'])->middleware('guest')->name('register');
Route::post('auth/login', [AuthenticationController::class, 'login'])->middleware('guest')->name('login');


// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('auth/logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::get('users/me', [UserController::class, 'me'])->name('users-current');
    Route::get('users', [UserController::class, 'index'])->name('users-list');
});
