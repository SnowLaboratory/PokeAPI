<?php

namespace Database\Seeders;

use App\Jobs\ImportPokemon;
use App\Models\Pokemon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\DataFetcher;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Illuminate\Support\Facades\Http;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api = new EndpointBuilder();

        $url = $api->getAllPokemon() . "?" . http_build_query([
            "limit" => 10000,
        ]);

        $data = Http::get($url)->json() ?? [];

        $this->command->getOutput()->progressStart($data['count']);

        foreach ($data['results'] as $info) {

            $pokemonInfoUrl = $info['url'];
            ImportPokemon::dispatch($pokemonInfoUrl);

            $this->command->getOutput()->progressAdvance();
        }


        $this->command->getOutput()->progressFinish();
    }
}
