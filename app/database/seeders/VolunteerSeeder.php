<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VolunteerSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            ['Mathis', 'De Baere', 'mathis@example.com', 'Vrijwilliger'],
            ['Mattias', 'De Gaere', 'mattias@example.com', 'Vrijwilliger'],
            ['Smurf', '1', 'smurf1@example.com', 'Smurf vrijwilliger 1'],
            ['Smurf', '2', 'smurf2@example.com', 'Smurf vrijwilliger 2'],
            ['Smurf', '3', 'smurf3@example.com', 'Smurf vrijwilliger 3'],
            ['Smurf', '4', 'smurf4@example.com', 'Smurf vrijwilliger 4'],
            ['Smurf', '5', 'smurf5@example.com', 'Smurf vrijwilliger 5'],
            ['Smurf', '6', 'smurf6@example.com', 'Smurf vrijwilliger 6'],
            ['Smurf', '7', 'smurf7@example.com', 'Smurf vrijwilliger 7'],
            ['Smurf', '8', 'smurf8@example.com', 'Smurf vrijwilliger 8'],
            ['Smurf', '9', 'smurf9@example.com', 'Smurf vrijwilliger 9'],
            ['Smurf', '10', 'smurf10@example.com', 'Smurf vrijwilliger 10'],
            ['Smurf', '11', 'smurf11@example.com', 'Smurf vrijwilliger 11'],
            ['Smurf', '12', 'smurf12@example.com', 'Smurf vrijwilliger 12'],
            ['Smurf', '13', 'smurf13@example.com', 'Smurf vrijwilliger 13'],
            ['Smurf', '14', 'smurf14@example.com', 'Smurf vrijwilliger 14'],
            ['Smurf', '15', 'smurf15@example.com', 'Smurf vrijwilliger 15'],
            ['Smurf', '16', 'smurf16@example.com', 'Smurf vrijwilliger 16'],
            ['Smurf', '17', 'smurf17@example.com', 'Smurf vrijwilliger 17'],
            ['Smurf', '18', 'smurf18@example.com', 'Smurf vrijwilliger 18'],
            ['Smurf', '19', 'smurf19@example.com', 'Smurf vrijwilliger 19'],
            ['Smurf', '20', 'smurf20@example.com', 'Smurf vrijwilliger 20'],
        ];

        foreach ($records as [$firstName, $lastName, $email, $description]) {
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'privacy_agreement' => true,
                'account_status' => 'verified',
            ]);

            Volunteer::create([
                'user_id' => $user->id,
                'personal_description' => $description,
            ]);
        }
    }
}