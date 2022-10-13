<?php

namespace App\Jobs;

use App\Models\Pokemon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ImportPokemon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pokemonInfoUrl;
    private $pokemonName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->pokemonInfoUrl = $info['url'];
        $this->pokemonName = $info['name'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pokemon = fetchJson($this->pokemonInfoUrl);

        $species = fetchJson($pokemon['species']['url']);

        $types = collect($pokemon['types'])->pluck('type.name');

        $games = collect($pokemon['game_indices'])->pluck('version.name');

        $abilities = collect($pokemon['abilities'])->pluck('ability.name');

        $habitat = $species['habitat'];

        $pokemonModel = Pokemon::firstOrCreate([
            "name" => $pokemon['name'],
            "weight" => $pokemon['weight'],
            "height" => $pokemon['height'],
            "capture_rate" => $species['capture_rate'],
            "is_legendary" => $species['is_legendary'],
            "is_mythical" => $species['is_mythical'],
            "pokemon_info_url" => $this->pokemonInfoUrl,
            "pokemon_species_url" => $pokemon['species']['url']
        ]);

        foreach($types as $pokemonTypeName)
        {
            ImportType::dispatchSync($pokemonTypeName, $pokemonModel);
        }

        foreach($games as $pokemonFeaturedIn)
        {
            ImportGame::dispatchSync($pokemonFeaturedIn, $pokemonModel);
        }

        if (isset($habitat))
        {
            ImportHabitat::dispatchSync($habitat['name'], $pokemonModel);
        }

        foreach($abilities as $ability)
        {
            ImportAbility::dispatchSync($ability, $pokemonModel);
        }
    }
}
