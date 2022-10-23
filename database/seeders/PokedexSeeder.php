<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Pokedex;
use App\Models\Species;

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

        $url = $api->getAllPokedexs() . "?" . http_build_query([
            "limit" => 10000,
        ]);

        $infoJson = fetchJson($url);

        // 3. Loop over a list of urls associated to each url
        $urls = collect($infoJson['results'])->pluck('url');

        $this->progressMap($urls, function($pokedexUrl) {

            // 4. Fetch all the data for a specific pokedexes
            $pokedexJson = fetchJson($pokedexUrl);

            // 5. Assign variables for easy access.
            $pokedex = Pokedex::firstOrCreate([
                'name' => $pokedexJson['name'],
                'is_main_series' => $pokedexJson['is_main_series'],
            ]);

            $speciesNames = [];
            $pivotData = [];

            // 5. Loop over each entry to build an array of species name and their entry numbers.
            foreach($pokedexJson['pokemon_entries'] as $entry) {
                $speciesNames[] = $entry['pokemon_species']['name'];
                $pivotData[] = [
                    'entry_number' => $entry['entry_number'],
                ];
            }

            // 6. Get species where name matches, maintain same order as $speciesName
            $speciesIds = Species::whereIn('name', $speciesNames)
                ->orderByRaw("FIELD(name, '". implode("','", $speciesNames) ."')")
                ->pluck('id');

            // 7. combine speciesIds and pivot data to attach species to pokedex.
            $pokedex->species()->attach($speciesIds->combine($pivotData));

        });
    }
}
