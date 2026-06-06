<?php

namespace Database\Seeders;

use App\Models\HelpRequestCategory;
use Illuminate\Database\Seeder;

class HelpRequestCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Vervoer', 'icon' => 'car'],
            ['name' => 'Boodschappen', 'icon' => 'shopping-cart'],
            ['name' => 'Gezelschap', 'icon' => 'users'],
            ['name' => 'Samen op stap', 'icon' => 'walking'],
            ['name' => 'Zorg voor huisdieren', 'icon' => 'paw'],
            ['name' => 'Hulp bij administratie', 'icon' => 'file-text'],
            ['name' => 'Klein tuinonderhoud', 'icon' => 'scissors'],
            ['name' => 'Kleine klusjes in huis', 'icon' => 'tool'],
            ['name' => 'Licht huishoudelijk werk', 'icon' => 'home'],
            ['name' => 'Koken', 'icon' => 'coffee'],
            ['name' => 'Oppas', 'icon' => 'heart'],
            ['name' => 'Andere', 'icon' => 'more-horizontal'],
        ];
        foreach ($categories as $category) {
            HelpRequestCategory::firstOrCreate(
                ['name' => $category['name']],
                ['icon' => $category['icon']]
            );
        }
    }
}