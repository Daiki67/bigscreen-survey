<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Submission;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        $question = Question::inRandomOrder()->first();
        $value = null;
        
        if ($question?->type === 'A') {
            $value = $this->faker->randomElement(["Oui", "Non"]);
        } elseif ($question?->type === 'B') {
            $value = $this->faker->randomElement([
                "regarder la TV en direct", 
                "regarder des films", 
                "travailler", 
                "jouer en solo", 
                "jouer en équipe",
                "Occulus Quest", 
                "Occulus Go", 
                "HTC Vive Pro", 
                "PSVR", 
                "Autre", 
                "Aucun",
                "SteamVR", 
                "Occulus store", 
                "Viveport", 
                "Windows store",
                "Oculus Quest", 
                "Oculus Rift/s", 
                "HTC Vive", 
                "Windows Mixed Reality", 
                "Valve index",
                "Homme", 
                "Femme", 
                "Préfère ne pas répondre"
            ]);
        } else {
            $value = $this->faker->randomElement([1, 2, 3, 4, 5]);
        }

        return [
            'submission_id' => Submission::inRandomOrder()->first()?->id,
            'question_id'   => $question?->id,
            'value'         => $value,
        ];
    }
}
