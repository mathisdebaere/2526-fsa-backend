<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'personal_description' => fake()->paragraph(2),
            'background_notes' => fake()->optional(0.4)->paragraph(),
            'status' => fake()->randomElement(['seeking help', 'not seeking']),
            'membership_active' => true,
            'user_id' => User::factory()->client()->verified(),
        ];
    }
}
