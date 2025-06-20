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
            'options'  => $this->faker->randomElement([null, ['Oui', 'Non'], ['A', 'B', 'C']]),
        ];
    }
}
