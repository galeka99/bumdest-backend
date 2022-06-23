<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
  Route::view('/', 'index');
  Route::view('/login', 'login');
  Route::post('/login', [UserController::class, 'login']);
});

Route::middleware('auth')->group(function() {
  Route::get('/user/info', [UserController::class, 'info']);
  
  Route::prefix('dashboard')->group(function() {
    Route::view('/', 'dashboard.index');
  });
  
  Route::prefix('products')->group(function() {
    Route::get('/', [ProjectController::class, 'index']);
    Route::view('/add', 'dashboard.products.add');
    Route::post('/add', [ProjectController::class, 'add']);
    Route::get('/{id}', [ProjectController::class, 'edit']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}/proposal', [ProjectController::class, 'delete_proposal']);
    Route::delete('/{id}/image', [ProjectController::class, 'delete_image']);
  });
});
