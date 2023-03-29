<?php

namespace Database\Factories;

use App\Models\Employe;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => fake()->text("30"),
            'description' => fake()->optional()->text(),
            'execution_date' => fake()->dateTimeBetween('now', '2 weeks'),
            'status' => fake()->randomElement(Task::$status),
            "employe_id" => fake()->numberBetween(1, 10)
        ];
    }
}
