<?php

namespace Database\Seeders;

use App\Jobs\ImportPokemon;
use App\Models\Pokemon;
use Database\Traits\CanAcceptParameters;
use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Input\InputArgument;

class PokemonSeeder extends Seeder
{

    use CanTruncateTables, CanDisplayProgress;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($params=null)
    {
        $this->truncate([
            'ability_pokemon',
            'game_pokemon',
            'gender_pokemon',
            'generation_pokemon',
            'habitat_pokemon',
            'pokemon_type',
            'pokemon_weakness',
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
