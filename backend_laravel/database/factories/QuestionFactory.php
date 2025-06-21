<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'title'    => $this->faker->sentence,
            'body' => $this->faker->sentence(10),
            'type'     => $this->faker->randomElement(['A', 'B', 'C']),
            'options'  => $this->faker->randomElement([
                null,
                ['Oui', 'Non'],
                [1, 2, 3, 4, 5],
                ["regarder la TV en direct", "regarder des films", "travailler", "jouer en solo", "jouer en équipe"],
                ["Occulus Quest", "Occulus Go", "HTC Vive Pro", "PSVR", "Autre", "Aucun"],
                ["SteamVR", "Occulus store", "Viveport", "Windows store"],
                ["Oculus Quest", "Oculus Rift/s", "HTC Vive", "Windows Mixed Reality", "Valve index"],
                ["Homme", "Femme", "Préfère ne pas répondre"]
            ]),
        ];
    }
}
