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

            // 5. Find or create a generation model.
            $generation = Generation::firstOrCreate([
                "name" => $generationJson['name'],
            ]);

            // 6. Get a list of all the species names in a generation.
            $speciesNames = collect($generationJson['pokemon_species'])->pluck('name');

            // 7. Get all existing species whose name matches.
            $species = Species::whereIn('name', $speciesNames);

            // 8. Associate many species models to the generation model.
            $generation->species()->saveMany($species);
        });
    }
}
