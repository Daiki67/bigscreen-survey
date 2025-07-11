<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Submission;

// Seeder pour remplir la table submissions avec des soumissions factices
class SubmissionSeeder extends Seeder
{
    /**
     * Exécute le seeder pour la table submissions.
     * Rôle : Générer un certain nombre de soumissions pour les tests
     * Paramètres : Aucun
     * Retour : void
     */
    public function run(): void
    {
        // Génère 100 soumissions en utilisant la factory Submission
        Submission::factory()->count(100)->create();
    }
}
