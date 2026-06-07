<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'start_date' => now()->subMonth()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
            'amount' => 5.00,
            'status' => 'active',
            'client_id' => Client::factory(),
        ];
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'end_date' => now()->subDay()->format('Y-m-d'),
            'status' => 'expired',
        ]);
    }
}
