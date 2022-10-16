<?php

namespace Database\Seeders;

use App\Jobs\ImportGame;
use App\Models\Game;
use App\Models\Pokemon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Database\Traits\CanTruncateTables;
use Database\Traits\CanDisplayProgress;

class GameSeeder extends Seeder
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
            'games',
            'game_pokemon'
        ]);

        // 2. Fetch all the pokemon from the API
        $api = new EndpointBuilder();
        $infoJson = fetchJson($api->getAllPokemon());

        // 3. Loop over a list of urls associated to each pokemon
        $urls = collect($infoJson['results'])->pluck('url');

        $this->progressMap($urls, function($pokemonUrl) {
            // 4. Fetch all the data for a specific pokemon
            $pokemonJson = fetchJson($pokemonUrl);

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
        });
    }
}
