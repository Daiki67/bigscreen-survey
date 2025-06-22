<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AuthController;


Route::controller(SurveyController::class)->prefix('survey')->group(function () {
    Route::get('/question', 'index');
    Route::post('/store', 'store');
    Route::get('/result/{token}', 'showResults');
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::controller(SurveyController::class)->prefix('survey')->group(function () {
        Route::get('/question', 'index');
        Route::get('/result/{token}', 'showResults');
    });

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/submission', 'index');
        Route::get('/submission/{id}', 'show');
        Route::post('/submission', 'store');
        Route::put('/submission/{id}', 'update');
        Route::delete('/submission/{id}', 'destroy');
    });

    Route::controller(AnswerController::class)->prefix('questions')->group(function () {
        Route::get('/answer', 'index');
        Route::get('/answer/{id}', 'show');
        Route::post('/answer', 'store');
        Route::put('/answer/{id}', 'update');
        Route::delete('/answer/{id}', 'destroy');
    });

});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
