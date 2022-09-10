<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Pokemon;

class InsertPokemon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:pokemon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts all Pokemon into the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new EndpointBuilder();
        $baseEndpoint = $api->getAllPokemon();
        $pokemons = Http::get('https://pokeapi.co/api/v2/pokemon/?limit=1154')->json() ?? [];

        for ($i = 0; $i <= count($pokemons['results']) - 1; $i++) {
            $pokemon = $pokemons['results'][$i]['name'];
            $pokemon_name = new Pokemon;
            $pokemon_name->pokemon_name = $pokemon;
            $pokemon_name->save();
        }
    }
}
