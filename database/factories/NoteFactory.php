<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Note::class;

    public function definition()
    {
        return [
            'task_id' => Task::factory(),
            'subject' => $this->faker->sentence,
            'note' => $this->faker->paragraph,
            'attachments' => null,
            'created_at' => $this->faker->dateTimeBetween('-2 months', '-1 months')
        ];
    }
}
