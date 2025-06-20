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
        return [
            'submission_id' => Submission::inRandomOrder()->first()?->id,
            'question_id'   => Question::inRandomOrder()->first()?->id,
            'value'         => $this->faker->sentence,
        ];
    }
}
