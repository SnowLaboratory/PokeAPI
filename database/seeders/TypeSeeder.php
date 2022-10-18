<?php

namespace Database\Seeders;

use App\Jobs\ImportType;
use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Database\Traits\CanTruncateTables;
use Database\Traits\CanDisplayProgress;

class TypeSeeder extends Seeder
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
            'types',
            'pokemon_type',
            'damage_relation'
        ]);

        // 2. Fetch all the types from the API
        $api = new EndpointBuilder();
        $typesJson = fetchJson($api->getAllTypes());

        // 3. Loop over a list of urls associated to each type
        $urls = collect($typesJson['results'])->pluck('url');

        $this->progressMap($urls, function($typeUrl) {

            // 4. Fetch all the data for a specific type
            $typeJson = fetchJson($typeUrl);

            // 5. Assign variables for easy access.
            $typeName = $typeJson['name'];
            $pokemonNames = collect($typeJson['pokemon'])->pluck('pokemon.name');

            // 6. Loop over every pokemon name
            foreach ($pokemonNames as $pokemonName) {
                // 7. Find pokemon by unique pokemon name.
                $pokemonDB = Pokemon::where('name', $pokemonName)->firstOrFail();

                // 8. Save Relation
                    $type = Type::firstOrCreate([
                        "name" => $typeName,
                    ]);
                    $type->pokemon()->save($pokemonDB);
            }
        });
    }
}
