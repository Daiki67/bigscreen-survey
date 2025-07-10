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
        $value = null;

        return [

            'submission_id' => Submission::factory(),
            'question_id'   => Question::factory(),
            'value'         => $value,

        ];
    }
}
