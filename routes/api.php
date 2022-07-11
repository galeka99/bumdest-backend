<?php

use App\Http\Controllers\BumdesApiController;
use App\Http\Controllers\DepositApiController;
use App\Http\Controllers\InvestmentApiController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\RatingApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\WithdrawApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
  // LOCATION
  Route::prefix('location')->group(function() {
    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('province/{id}', [LocationController::class, 'cities']);
    Route::get('city/{id}', [LocationController::class, 'districts']);
  });

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

    // WITHDRAW
    Route::prefix('withdraw')->group(function() {
      Route::get('methods', [WithdrawApiController::class, 'payment_method']);
      Route::post('request', [DepositApiController::class, 'request']);
      Route::get('history', [WithdrawApiController::class, 'history']);
      Route::get('detail/{id}', [WithdrawApiController::class, 'detail']);
    });

    // PRODUCT
    Route::prefix('product')->group(function() {
      Route::get('newest', [ProjectApiController::class, 'newest']);
      Route::get('random', [ProjectApiController::class, 'random']);
      Route::get('almost_end', [ProjectApiController::class, 'almost_end']);
      Route::get('detail/{id}', [ProjectApiController::class, 'detail']);
      Route::post('invest', [ProjectApiController::class, 'invest']);
    });

    // INVESTMENT
    Route::prefix('investment')->group(function() {
      Route::get('/', [InvestmentApiController::class, 'list']);
      Route::get('/{id}', [InvestmentApiController::class, 'detail']);
    });

    // RATING
    Route::prefix('rating')->group(function() {
      Route::get('/{id}', [RatingApiController::class, 'check']);
      Route::post('/{id}/rate', [RatingApiController::class, 'rate']);
    });

    // BUMDES
    Route::prefix('bumdes')->group(function() {
      Route::get('/', [BumdesApiController::class, 'list']);
      Route::get('/{id}', [BumdesApiController::class, 'detail']);
      Route::get('/{id}/products', [BumdesApiController::class, 'product_list']);
    });
  });
});