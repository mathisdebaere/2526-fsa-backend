<?php

namespace Database\Factories;

use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('now', '+4 months')->format('Y-m-d'),
            'time_of_day' => fake()->randomElement(['morning', 'afternoon', 'evening']),
            'volunteer_id' => Volunteer::factory(),
        ];
    }
}
