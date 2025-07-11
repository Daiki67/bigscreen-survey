<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AuthController;

// Routes publiques pour le sondage (consultation et soumission)
Route::controller(SurveyController::class)->prefix('survey')->group(function () {
    Route::get('/question', 'index'); // Récupère toutes les questions du sondage
    Route::post('/store', 'store');   // Enregistre les réponses d'un utilisateur
    Route::get('/result/{token}', 'showResults'); // Affiche les réponses d'un utilisateur via son token
});

// Routes protégées par Sanctum pour l'administration
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

    // Gestion des questions du sondage (admin)
    Route::controller(SurveyController::class)->prefix('survey')->group(function () {
        Route::get('/questions', 'index'); // Récupère toutes les questions (admin)
    });

    // Statistiques du tableau de bord (admin)
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/datacharts', 'index'); // Récupère les données pour les graphiques
    });

    // Gestion des réponses (admin)
    Route::controller(AnswerController::class)->prefix('answers')->group(function () {
        Route::get('/all', 'index'); // Récupère toutes les réponses
    });

    // Authentification admin
    Route::get('/auth', [AuthController::class, 'AuthAdmin']); // Vérifie l'authentification admin
    Route::delete('/logout', [AuthController::class, 'logout']); // Déconnexion admin
});

// Route publique pour la connexion
Route::post('/login', [AuthController::class, 'login']); // Connexion utilisateur/admin
