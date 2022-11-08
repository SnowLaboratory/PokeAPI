<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Habitat;
use App\Models\Species;

class HabitatSeeder extends Seeder
{
    use CanTruncateTables;
    use CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'habitats',
        ]);

        $api = new EndpointBuilder();
        $habitatJson = fetchJson($api->getAllPokemonHabitats());

        // 3. Loop over a list of urls associated to each habitat
        $urls = collect($habitatJson['results'])->pluck('url');
        $this->progressMap($urls, function ($habitatUrl) {
            // 4. Fetch all the data for a specific habitat
            $habitatJson = fetchJson($habitatUrl);

            // 5. Find or create a habitat model.
            $habitat = Habitat::firstOrCreate([
                "name" => $habitatJson['name'],
            ]);

            // 6. Get a list of all the species names in a habitat.
            $speciesNames = collect($habitatJson['pokemon_species'])->pluck('name');

            // 7. Get all existing species whose name matches.
            $species = Species::whereIn('name', $speciesNames);

            // 8. Associate many species models to the habitat model.
            $habitat->species()->saveMany($species);
        });
    }
}
