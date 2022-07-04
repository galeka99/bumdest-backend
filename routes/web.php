<?php

use App\Http\Controllers\DepositController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

$app_url = config("app.url");
if (app()->environment('prod') && !empty($app_url)) {
    URL::forceRootUrl($app_url);
    $schema = explode(':', $app_url)[0];
    URL::forceScheme($schema);
}

Route::middleware('guest')->group(function() {
  Route::get('/', function () {
    return redirect('/login');
  });
  Route::view('/login', 'login');
  Route::post('/login', [UserController::class, 'login']);
});

Route::middleware('auth')->group(function() {
  Route::get('/user/info', [UserController::class, 'info']);
  Route::get('/logout', [UserController::class, 'logout']);
  
  // DASHBOARD
  Route::prefix('dashboard')->group(function() {
    Route::view('/', 'dashboard.index');
  });

  // TOPUP BALANCE
  Route::prefix('topup')->group(function() {
    Route::get('/', [DepositController::class, 'history']);
    Route::post('/', [DepositController::class, 'request']);
  });

  // TOPUP BALANCE
  Route::prefix('withdraw')->group(function() {
    Route::get('/', [WithdrawController::class, 'history']);
    Route::post('/', [WithdrawController::class, 'request']);
  });
  
  // PRODUCT
  Route::prefix('products')->group(function() {
    Route::get('/', [ProjectController::class, 'index']);
    Route::view('/add', 'dashboard.products.add');
    Route::post('/add', [ProjectController::class, 'add']);
    Route::get('/{id}', [ProjectController::class, 'edit']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}/proposal', [ProjectController::class, 'delete_proposal']);
    Route::delete('/{id}/image', [ProjectController::class, 'delete_image']);
  });

  // INVESTMENT
  Route::prefix('investments')->group(function() {
    Route::get('/', [InvestmentController::class, 'list']);
    Route::post('/{id}/accept', [InvestmentController::class, 'accept']);
    Route::post('/{id}/reject', [InvestmentController::class, 'reject']);
  });

  // INVESTMENT
  Route::prefix('investors')->group(function() {
    Route::get('/', [InvestorController::class, 'list']);
    Route::get('/{id}', [InvestorController::class, 'detail']);
  });
});
