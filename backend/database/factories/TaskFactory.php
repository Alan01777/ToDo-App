<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $status = ['pending', 'completed', 'in progress'];

        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(10),
            'status' => Arr::random($status),
            'due_date' => $this->faker->dateTimeThisYear(),
            'priority' => $this->faker->numberBetween(1, 3),
        ];
    }
}