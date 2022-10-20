<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Pokedex;
use App\Models\Species;
use App\Models\Region;

class PokedexSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'pokedexes',
            'pokedex_species',
        ]);

        // 2. Fetch all the pokedexes from the API
        $api = new EndpointBuilder();
        $infoJson = fetchJson($api->getAllPokedexs());

        // 3. Loop over a list of urls associated to each url
        $urls = collect($infoJson['results'])->pluck('url');

        $this->progressMap($urls, function($pokedexUrl) {

            // 4. Fetch all the data for a specific pokedexes
            $pokedexJson = fetchJson($pokedexUrl);

            // 5. Assign variables for easy access.
            $pokedexName = $pokedexJson['name'];

            // $speciesNames = collect($pokedexJson['pokemon_entries'])->pluck('pokemon_species.name');


            // 6. Save Pokedex
            $pokedex = Pokedex::firstOrCreate([
                'name' => $pokedexName,
                'is_main_series' => $pokedexJson['is_main_series'],
            ]);
            // 7. Loop over every pokemon name
            foreach ($pokedexJson['pokemon_entries'] as $entry) {

                // 8. Find pokemon by unique pokemon name.
                $speciesJson = $entry['pokemon_species'];
                $speciesDB = Species::firstWhere('name', $speciesJson['name']);

                // 9. save pivot relation
                $pokedex->species()->attach($speciesDB, [
                    'entry_number' => $entry['entry_number'],
                ]);
            }

            // 10. Assign region
            // $region = Region::firstWhere('name', optional($pokedexJson['region'])['name']);

        });
    }
}
