<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use App\Models\Species;
use Database\Traits\CanAcceptParameters;
use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;

class SpeciesSeeder extends Seeder
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
            'species'
        ]);

        // 2. Fetch all the types from the API
        $api = new EndpointBuilder();
        $url = $api->getAllPokemonSpecies() . "?" . http_build_query([
            "limit" => 10000,
        ]);
        $indexJson = fetchJson($url);

        // 3. Loop over a list of urls associated to each type
        $urls = collect($indexJson['results'])->pluck('url');

        $this->progressMap($urls, function ($speciesUrl) {

            // 4. Fetch all the data for a specific type
            $speciesJson = fetchJson($speciesUrl);

            // 5. Assign variables for easy access.
            $typeName = $speciesJson['name'];
            $pokemonNames = collect($speciesJson['varieties'])->pluck('pokemon.name');

            // 6. Save Species to Database
            $species = Species::firstOrCreate([
                'name' => $speciesJson['name'],
                'capture_rate' => $speciesJson['capture_rate'],
                'is_legendary' => $speciesJson['is_legendary'],
                'is_mythical' => $speciesJson['is_mythical']
            ]);

            // 7. Loop over every pokemon name
            foreach ($pokemonNames as $pokemonName) {
                // 8. Find pokemon by unique pokemon name.
                $pokemonDB = Pokemon::firstWhere('name', $pokemonName);

                // 9. Save pokemon/species relationship
                $species->pokemon()->save($pokemonDB);
            }

        });
    }
}
