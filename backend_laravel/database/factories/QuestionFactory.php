<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

// Fabrique pour générer des instances de Question pour les tests et le seed
class QuestionFactory extends Factory
{
    // Le modèle associé à cette fabrique
    protected $model = Question::class;

    /**
     * Définition des valeurs par défaut pour une instance de Question
     * Rôle : Générer des données factices pour les champs d'une question
     * Paramètres : Aucun
     * Retour : array des champs à remplir pour la création d'une question
     */
    public function definition(): array
    {
        return [
            'title'    => $this->faker->sentence, // Titre de la question
            'body'     => $this->faker->sentence(10), // Corps/texte de la question
            'type'     => $this->faker->randomElement(['A', 'B', 'C']), // Type de la question
            'options'  => $this->faker->randomElement([
                null,
                ['Oui', 'Non'],
                [1, 2, 3, 4, 5],
                ["regarder la TV en direct", "regarder des films", "travailler", "jouer en solo", "jouer en équipe"],
                ["Occulus Quest", "Occulus Go", "HTC Vive Pro", "PSVR", "Autre", "Aucun"],
                ["SteamVR", "Occulus store", "Viveport", "Windows store"],
                ["Oculus Quest", "Oculus Rift/s", "HTC Vive", "Windows Mixed Reality", "Valve index"],
                ["Homme", "Femme", "Préfère ne pas répondre"]
            ]), // Options de réponse possibles
        ];
    }
}
