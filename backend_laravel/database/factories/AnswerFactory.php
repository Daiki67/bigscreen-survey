<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Submission;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use PHPUnit\TextUI\Configuration\Merger;

// Fabrique pour générer des instances de Answer (réponse) pour les tests et le seed
class AnswerFactory extends Factory
{
    // Le modèle associé à cette fabrique
    protected $model = Answer::class;

    /**
     * Définition des valeurs par défaut pour une instance de Answer
     * Rôle : Générer des données factices pour les champs d'une réponse
     * Paramètres : Aucun
     * Retour : array des champs à remplir pour la création d'une réponse
     */
    public function definition(): array
    {
        $value = null; // Valeur de la réponse (à adapter selon le type de question si besoin)

        return [
            'submission_id' => Submission::factory(), // Associe une soumission générée
            'question_id'   => Question::factory(),   // Associe une question générée
            'value'         => $value,                // Valeur de la réponse
        ];
    }
}
