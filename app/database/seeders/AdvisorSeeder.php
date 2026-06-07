<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdvisorSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Tine',
            'last_name' => 'Vandamme',
            'email' => 'tine@zilverenschakel.be',
            'password' => Hash::make('password'),
            'role' => 'advisor',
            'privacy_agreement' => true,
            'account_status' => 'verified',
        ]);

        Advisor::create([
            'user_id' => $user->id,
        ]);
    }
}
