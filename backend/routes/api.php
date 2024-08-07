<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
  Route::post('login', [AuthController::class, 'login'])->name('login'); // Define the "login" route
  Route::post('register', [AuthController::class, 'register'])->name('register');

  Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('user', [AuthController::class, 'user'])->name('user');
  });
});

Route::middleware('auth:sanctum')->group(function () {
  Route::resource('/users', UserController::class);
  Route::resource('/tasks', TaskController::class);
  Route::resource('/tags', TagController::class);
  Route::resource('/categories', CategoryController::class);
});
