<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LgaSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if already seeded
        if (Lga::count() > 100) {
            $this->command->info('LGAs already seeded. Skipping.');
            return;
        }

        $data = require database_path('data/lgas.php');

        foreach ($data as $stateCode => $lgaNames) {
            $state = State::where('code', $stateCode)->first();
            if (! $state) {
                continue;
            }

            foreach ($lgaNames as $name) {
                Lga::updateOrCreate(
                    ['state_id' => $state->id, 'name' => $name],
                    ['slug' => Str::slug($name)]
                );
            }
        }

        $this->command->info('Seeded ' . Lga::count() . ' LGAs.');
    }
}