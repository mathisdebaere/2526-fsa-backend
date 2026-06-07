<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HelpRequestCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'description' => fake()->optional(0.7)->sentence(),
            'icon' => fake()->optional(0.5)->word(),
        ];
    }
}
