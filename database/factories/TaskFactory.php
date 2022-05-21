<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
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
    protected $model = Task::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->dateTimeBetween('-1 months', '+7 days')->format('Y-m-d'),
            'due_date' => $this->faker->dateTimeBetween('+7 days', '+1 months')->format('Y-m-d'),
            'status' => $this->faker->randomElement(['New', 'Incomplete', 'Complete']),
            'priority' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months')
        ];
    }
}
