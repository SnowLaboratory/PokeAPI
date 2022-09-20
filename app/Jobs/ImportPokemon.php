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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pokemonInfoUrl)
    {
        $this->pokemonInfoUrl = $pokemonInfoUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pokemon = Http::get($this->pokemonInfoUrl)->json() ?? [];

        $species = Http::get($pokemon['species']['url'])->json() ?? [];

        Pokemon::create([
            "name" => $pokemon['name'],
            "weight" => $pokemon['weight'],
            "height" => $pokemon['height'],
            "capture_rate" => $species['capture_rate'],
            "is_legendary" => $species['is_legendary'],
            "is_mythical" => $species['is_mythical'],
        ]);
    }
}
