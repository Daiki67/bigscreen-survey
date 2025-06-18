<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->prefix('users')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });

});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/users', 'index');
        Route::get('/users/{id}', 'show');
        Route::post('/users', 'store');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
    });

});

Route::post('/register',[AuthController::class , 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
