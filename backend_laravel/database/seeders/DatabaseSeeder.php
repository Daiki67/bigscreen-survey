<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Seeder principal qui exécute tous les seeders de l'application
class DatabaseSeeder extends Seeder
{
    /**
     * Exécute le seeder principal de l'application.
     * Rôle : Remplir la base de données avec des données de test (utilisateurs, questions, soumissions, réponses)
     * Paramètres : Aucun
     * Retour : void
     */
    public function run(): void
    {
        // Création d'un utilisateur administrateur par défaut
        User::factory()->create([
            'name' => 'Admin', // Nom de l'utilisateur admin
            'email' => 'admin@gmail.com', // Email de l'utilisateur admin
            'password' => 'password123', // Mot de passe (à hasher en production !)
        ]);

        // Exécution des seeders pour les questions, soumissions et réponses
        $this->call([
            QuestionSeeder::class,   // Remplit la table questions
            SubmissionSeeder::class, // Remplit la table submissions
            AnswerSeeder::class,     // Remplit la table answers
        ]);
    }
}
