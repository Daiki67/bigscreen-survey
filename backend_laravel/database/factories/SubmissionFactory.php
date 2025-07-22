<?php

namespace Database\Factories;

use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

// Fabrique pour générer des instances de Submission pour les tests et le seed
class SubmissionFactory extends Factory
{
    // Le modèle associé à cette fabrique
    protected $model = Submission::class;

    /**
     * Définition des valeurs par défaut pour une instance de Submission
     * Rôle : Générer des données factices pour les champs d'une soumission
     * Paramètres : Aucun
     * Retour : array des champs à remplir pour la création d'une soumission
     */
    public function definition(): array
    {
        return [
            'url_token' => $this->faker->unique()->uuid, // Jeton unique de la soumission
        ];
    }
}
