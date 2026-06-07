<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HelpRequestCategorySeeder::class,
            AdvisorSeeder::class,
            ClientSeeder::class,
            VolunteerSeeder::class,
            HelpRequestSeeder::class,
        ]);
    }
}
