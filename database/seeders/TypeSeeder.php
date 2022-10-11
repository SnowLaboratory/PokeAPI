<?php

namespace Database\Seeders;

use App\Jobs\ImportType;
use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // 1. Truncate the table so you can run seeder by itself
        Type::truncate();

        // 2. Fetch all the types from the API
        $api = new EndpointBuilder();
        $typesJson = Http::get($api->getAllTypes())->json() ?? [];

        // 3. Loop over a list of urls associated to each type
        $urls = collect($typesJson['results'])->pluck('url');
        foreach ($urls as $typeUrl) {

            // 4. Fetch all the data for a specific type
            $typeJson = Http::get($typeUrl)->json() ?? [];

            // 5. Assign variables for easy access.
            $typeName = $typeJson['name'];
            $pokemonNames = collect($typeJson['pokemon'])->pluck('pokemon.name');

            // 6. Loop over every pokemon name
            foreach ($pokemonNames as $pokemonName) {
                // 7. Find pokemon by unique pokemon name.
                $pokemonDB = Pokemon::where('name', $pokemonName)->firstOrFail();

                // 8. Dispatch ImportType job
                ImportType::dispatch($typeName, $pokemonDB);
            }
        }
    }
}
