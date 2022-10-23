<?php

namespace Database\Seeders;

use App\Models\Pokemon;
use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;

class PokemonSeeder extends Seeder
{

    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'ability_pokemon',
            'game_pokemon',
            'gender_pokemon',
            'pokemon_type',
            'pokemon',
        ]);

        $api = new EndpointBuilder();

        $url = $api->getAllPokemon() . "?" . http_build_query([
            "limit" => 10000,
        ]);


        $indexJson = fetchJson($url);
        $urls = collect($indexJson['results'])->pluck('url');

        $this->progressMap($urls, function($pokemonUrl) {

            $pokemonJson = fetchJson($pokemonUrl);

            Pokemon::firstOrCreate([
                'name' => $pokemonJson['name'],
                'weight' => $pokemonJson['weight'],
                'height' => $pokemonJson['height'],
                'is_default' => $pokemonJson['is_default'],
            ]);

        });
    }
}
