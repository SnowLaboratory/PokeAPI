<?php

namespace Database\Seeders;


use App\Models\Species;
use App\Models\Generation;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Database\Traits\CanTruncateTables;
use Database\Traits\CanDisplayProgress;

class GenerationSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Truncate the table so you can run seeder by itself
        $this->truncate([
            'generations',
        ]);

        // 2. Fetch all the generations from the API
        $api = new EndpointBuilder();
        $generationJson = fetchJson($api->getAllGenerations());

        // 3. Loop over a list of urls associated to each generation
        $urls = collect($generationJson['results'])->pluck('url');
        $this->progressMap($urls, function($generationUrl) {

            // 4. Fetch all the data for a specific generation
            $generationJson = fetchJson($generationUrl);

            // 5. Assign variables for easy access.
            $generationName = $generationJson['name'];
            $speciesNames = collect($generationJson['pokemon_species'])->pluck('name');

            $generation = Generation::firstOrCreate([
                "name" => $generationName,
            ]);

            // 6. Loop over every pokemon name
            foreach ($speciesNames as $speciesName) {
                // 7. Find pokemon by unique pokemon name.

                $speciesDB = Species::firstWhere('name', $speciesName);

                // 8. Save Relation
                $speciesDB->generation()->associate($generation)->save();
            }
        });
    }
}
