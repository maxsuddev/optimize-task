<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'lead_id' => Lead::factory(),
            'title' => fake()->sentence(),
            'due_at' => fake()->optional(0.6)->dateTimeBetween('now', '+30 days'),
            'is_done' => fake()->boolean(30),
            'created_at' => fake()->dateTimeBetween('-20 days', 'now'),
        ];
    }

    
}