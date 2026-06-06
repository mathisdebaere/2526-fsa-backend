<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::create([
            'first_name' => 'Joris',
            'last_name' => 'Maervoet',
            'email' => 'joris@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'privacy_agreement' => true,
            'account_status' => 'verified',
        ]);

        Client::create([
            'user_id' => $user1->id,
            'status' => 'seeking help',
            'membership_active' => true,
            'personal_description' => 'Ik ben Joris en ik geef backend vakskes op Odisee',
        ]);

        $user2 = User::create([
            'first_name' => 'Bart',
            'last_name' => 'Delrue',
            'email' => 'bart@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'privacy_agreement' => true,
            'account_status' => 'verified',
        ]);

        Client::create([
            'user_id' => $user2->id,
            'status' => 'seeking help',
            'membership_active' => true,
            'personal_description' => 'Ik ben Bart en ik geef frontend vakskes op Odisee',
        ]);
    }
}