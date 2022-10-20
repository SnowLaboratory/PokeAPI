<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Ability;
use App\Models\Pokemon;


class AbilitySeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'abilities',
            'ability_pokemon',
        ]);

        // 2. Fetch all the abilities from the API
        $api = new EndpointBuilder();
        $infoJson = fetchJson($api->getAllAbilities());

        // 3. Loop over a list of urls associated to each ability
        $urls = collect($infoJson['results'])->pluck('url');

        $this->progressMap($urls, function($abilityUrl) {

            // 4. Fetch all the data for a specific ability
            $abilityJson = fetchJson($abilityUrl);

            // 5. Assign variables for easy access.
            $abilityName = $abilityJson['name'];

            $pokemonNames = collect($abilityJson['pokemon'])->pluck('pokemon.name');

            // 6. Loop over every pokemon name
            foreach ($pokemonNames as $pokemon) {

                // 7. Find pokemon by unique pokemon name.
                $pokemonDB = Pokemon::firstWhere('name', $pokemon);

                // 8. Save Relation
                $ability = Ability::firstOrCreate([
                    'name' => $abilityName,
                ]);
                $ability->pokemon()->save($pokemonDB);
            }
        });
    }
}
