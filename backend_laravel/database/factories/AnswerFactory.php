<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Submission;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use PHPUnit\TextUI\Configuration\Merger;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        $question = Question::inRandomOrder()->first();
        $value = null;

        if ($question?->type === 'A') {

            if ($question?->id === 3) {

                $value = $this->faker->randomElement([
                    "Homme",
                    "Femme",
                    "Préfère ne pas répondre"
                ]);

            } elseif($question?->id === 6) {

                $value = $this->faker->randomElement([
                    "Oculus Quest",
                    "Oculus Rift/s",
                    "HTC Vive",
                    "Windows Mixed Reality",
                    "Valve index",
                ]);

            } elseif ($question?->id === 7) {

                $value = $this->faker->randomElement([
                    "SteamVR",
                    "Occulus store",
                    "Viveport",
                    "Windows store",
                ]);
            
            } elseif( $question?->id === 8) {

                $value = $this->faker->randomElement([
                    "Occulus Quest",
                    "Occulus Go",
                    "HTC Vive Pro",
                    "PSVR",
                    "Autre",
                    "Aucun",
                ]);

            } elseif ($question?->id === 10) {

                $value = $this->faker->randomElement([
                    "regarder la TV en direct",
                    "regarder des films",
                    "travailler",
                    "jouer en solo",
                    "jouer en équipe",
                ]);

            } else {

                $value = $this->faker->randomElement(["Oui", "Non"]);

            }
        } elseif ($question?->type === 'B') {

            $value = $this->faker->sentence(3);

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
