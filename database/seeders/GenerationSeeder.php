<?php

namespace Database\Seeders;

use App\Jobs\ImportGeneration;
use App\Models\Pokemon;
use App\Models\Generation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
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
            'generation_pokemon'
        ]);

        // 2. Fetch all the generations from the API
        $api = new EndpointBuilder();
        $generationJson = fetchJson($api->getAllGenerations());

        // 3. Loop over a list of urls associated to each generation
        $urls = collect($generationJson['results'])->pluck('url');
        foreach ($urls as $generationUrl) {

            // 4. Fetch all the data for a specific generation
            $generationJson = fetchJson($generationUrl);

            // 5. Assign variables for easy access.
            $generationName = $generationJson['name'];
            $pokemonNames = collect($generationJson['pokemon_species'])->pluck('name');

            // 6. Loop over every pokemon name
            // foreach ($pokemonNames as $pokemonName) {
            //     // 7. Find pokemon by unique pokemon name.

            //     $pokemonDB = Pokemon::where('name', $pokemonName)->firstOrFail();

            //     // 8. Dispatch ImportType job
            //     ImportGeneration::dispatch($generationName, $pokemonDB);
            // }
        }
    }
}
