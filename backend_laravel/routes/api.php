<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AuthController;
use Laravel\Sanctum\Sanctum;

Route::controller(SurveyController::class)->prefix('survey')->group(function () {
    Route::get('/question', 'index');
    Route::post('/store', 'store');
    Route::get('/result/{token}', 'showResults');
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    Route::controller(SurveyController::class)->prefix('survey')->group(function () {
        Route::get('/questions', 'index');
    });

    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/datacharts', 'index');
    });

    Route::controller(AnswerController::class)->prefix('answers')->group(function () {
        Route::get('/all', 'index');
    });

    Route::get('/auth', [AuthController::class, 'AuthAdmin']);
    Route::delete('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login']);
