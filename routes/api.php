<?php

use App\Http\Controllers\DepositApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
  Route::prefix('user')->group(function() {
    Route::post('register', [UserApiController::class, 'register']);
    Route::post('login', [UserApiController::class, 'login']);

    Route::middleware('auth.user')->group(function() {
      Route::get('info', [UserApiController::class, 'userinfo']);
    });
  });

  Route::middleware('auth.user')->group(function() {

    // DEPOSIT
    Route::prefix('deposit')->group(function() {
      Route::get('methods', [DepositApiController::class, 'payment_method']);
      Route::post('request', [DepositApiController::class, 'request']);
      Route::get('history', [DepositApiController::class, 'history']);
      Route::get('detail/{id}', [DepositApiController::class, 'detail']);
    });

  });
});