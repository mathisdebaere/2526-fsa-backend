<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'role' => fake()->randomElement(['volunteer', 'client']),
            'privacy_agreement' => true,
            'privacy_agreement_timestamp' => now(),
            'account_status' => 'waiting_for_interview',
        ];
    }

    public function client(): static
    {
        return $this->state(fn () => ['role' => 'client']);
    }

    public function volunteer(): static
    {
        return $this->state(fn () => ['role' => 'volunteer']);
    }

    public function advisor(): static
    {
        return $this->state(fn () => ['role' => 'advisor']);
    }

    public function verified(): static
    {
        return $this->state(fn () => ['account_status' => 'verified']);
    }
}
