<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/users', UserController::class);
Route::resource('/tasks', TaskController::class);
Route::resource('/tags', TagController::class);
Route::resource('/categories', CategoryController::class);