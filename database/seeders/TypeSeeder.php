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

            // 5. Find or create a type model.
            $type = Type::firstOrCreate([
                "name" => $typeJson['name'],
            ]);

            // 6. Get a list of all the pokemon names for a type.
            $pokemonNames = collect($typeJson['pokemon'])->pluck('pokemon.name');

            // 7. Get all existing pokemon whose name matches.
            $pokemon = Pokemon::whereIn('name', $pokemonNames);

            // 8. Associate many pokemon models to the type model.
            $type->pokemon()->saveMany($pokemon);
        });
    }
}
