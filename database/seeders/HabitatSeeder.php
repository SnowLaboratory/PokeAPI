<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Habitat;
use App\models\Species;

class HabitatSeeder extends Seeder
{
    use cantruncateTables;
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

            // 5. Assign variables for easy access.
            $habitatName = $habitatJson['name'];
            $speciesNames = collect($habitatJson['pokemon_species'])->pluck('name');

            $habitat = Habitat::firstOrCreate([
                "name" => $habitatName,
            ]);

            // 6. Loop over every pokemon name
            foreach ($speciesNames as $speciesName) {
                // 7. Find pokemon by unique pokemon name.

                $speciesDB = Species::firstWhere('name', $speciesName);

                // 8. Save Relation
                $speciesDB->habitat()->associate($habitat)->save();
            }
        });
    }
}
