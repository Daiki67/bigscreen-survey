<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    /* Route::controller(QuestionController::class)->prefix('questions')->group(function () {
        Route::get('/question', 'index');
        Route::get('/question/{id}', 'show');
        Route::post('/question', 'store');
        Route::put('/question/{id}', 'update');
        Route::delete('/question/{id}', 'destroy');
    }); */

});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
