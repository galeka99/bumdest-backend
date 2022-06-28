<?php

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
});