<?php

use App\Http\Controllers\BumdesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::prefix('review')->group(function() {
  Route::get('{bumdes_code}', [ReviewController::class, 'review']);
  Route::post('{bumdes_code}', [ReviewController::class, 'submit_review']);
});

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
    Route::get('/', [DashboardController::class, 'index']);
  });

  // ROUTE FOR ADMIN ROLE
  Route::middleware('auth.admin')->group(function() {
    Route::prefix('bumdes')->group(function() {
      Route::get('/', [BumdesController::class, 'list']);
      Route::get('/add', [BumdesController::class, 'add']);
      Route::get('/{id}', [BumdesController::class, 'edit']);
      Route::post('/add', [BumdesController::class, 'insert']);
      Route::put('/{id}', [BumdesController::class, 'update']);
    });
  });

  // ROUTE FOR BUMDES ROLE
  Route::middleware('auth.bumdes')->group(function() {
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
  
    // MONTHLY REPORTS
    Route::prefix('reports')->group(function() {
      Route::get('/', [MonthlyReportController::class, 'index']);
      Route::post('/', [MonthlyReportController::class, 'add']);
      Route::get('/{id}', [MonthlyReportController::class, 'detail']);
    });
  
    // PROFILE
    Route::prefix('profile')->group(function() {
      Route::get('/', [UserController::class, 'profile']);
      Route::put('/', [UserController::class, 'update_profile']);
    });
  });
});
