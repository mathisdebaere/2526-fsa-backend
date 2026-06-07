<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\HelpRequestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class HelpRequestFactory extends Factory
{
    private static array $municipalities = [
        'Gent', 'Antwerpen', 'Brugge', 'Leuven', 'Mechelen',
        'Hasselt', 'Kortrijk', 'Aalst', 'Sint-Niklaas', 'Turnhout',
        'Genk', 'Dendermonde', 'Roeselare', 'Ieper', 'Oudenaarde',
        'Waregem', 'Deinze', 'Eeklo', 'Tielt', 'Diksmuide',
        'Aarschot', 'Diest', 'Herentals', 'Mol', 'Beringen',
        'Lommel', 'Tongeren', 'Maaseik', 'Bilzen', 'Vilvoorde',
    ];

    public function definition(): array
    {
        return [
            'extra_notes' => fake()->optional(0.6)->sentence(),
            'region' => fake()->randomElement(self::$municipalities),
            'date' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'time' => fake()->time('H:i'),
            'status' => fake()->randomElement(['open', 'open', 'open', 'matched', 'completed', 'cancelled']),
            'help_request_category_id' => HelpRequestCategory::factory(),
            'client_id' => Client::factory(),
        ];
    }
}
