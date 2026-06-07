<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\HelpRequest;
use Illuminate\Database\Seeder;

class HelpRequestSeeder extends Seeder
{
    public function run(): void
    {
        $joris = Client::whereHas('user', function ($query) {
            $query->where('first_name', 'Joris')
                ->where('last_name', 'Maervoet');
        })->first();

        $bart = Client::whereHas('user', function ($query) {
            $query->where('first_name', 'Bart')
                ->where('last_name', 'Delrue');
        })->first();

        HelpRequest::create([
            'client_id' => $joris->id,
            'help_request_category_id' => 1,
            'region' => 'Gent',
            'date' => now()->addDays(3),
            'time' => '14:00:00',
            'status' => 'open',
            'extra_notes' => 'Hulp nodig bij computerinstellingen.',
        ]);

        HelpRequest::create([
            'client_id' => $joris->id,
            'help_request_category_id' => 2,
            'region' => 'Gent',
            'date' => now()->addDays(5),
            'time' => '10:00:00',
            'status' => 'open',
            'extra_notes' => 'Begeleiding naar afspraak.',
        ]);

        HelpRequest::create([
            'client_id' => $bart->id,
            'help_request_category_id' => 1,
            'region' => 'Brugge',
            'date' => now()->addWeek(),
            'time' => '09:30:00',
            'status' => 'open',
            'extra_notes' => 'Probleem met smartphone.',
        ]);

        HelpRequest::create([
            'client_id' => $bart->id,
            'help_request_category_id' => 3,
            'region' => 'Brugge',
            'date' => now()->addDays(10),
            'time' => '15:00:00',
            'status' => 'open',
            'extra_notes' => 'Hulp bij administratie.',
        ]);
    }
}
