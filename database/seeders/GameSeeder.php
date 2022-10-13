<?php

namespace Database\Seeders;

use App\Jobs\ImportGame;
use App\Models\Game;
use App\Models\Pokemon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Truncate the table so you can run seeder by itself
        Game::truncate();

        // 2. Fetch all the pokemon from the API
        $api = new EndpointBuilder();
        $infoJson = Http::get($api->getAllPokemon())->json() ?? [];

        // 3. Loop over a list of urls associated to each pokemon
        $urls = collect($infoJson['results'])->pluck('url');
        foreach ($urls as $pokemonUrl) {

            // 4. Fetch all the data for a specific pokemon
            $pokemonJson = Http::get($pokemonUrl)->json() ?? [];

            // 5. Assign variables for easy access.
            $pokemonName = $pokemonJson['name'];
            $gameNames = collect($pokemonJson['game_indices'])->pluck('version.name');

            // 6. Loop over every pokemon name
            foreach ($gameNames as $pokemonFeaturedIn) {
                // 7. Find pokemon by unique pokemon name.
                $pokemonDB = Pokemon::where('name', $pokemonName)->firstOrFail();

                // 8. Dispatch ImportType job
                ImportGame::dispatch($pokemonFeaturedIn, $pokemonDB);
            }
        }
    }
}
