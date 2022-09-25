<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\Pokemon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use PDO;

class ImportGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $pokemonFeaturedIn;
    private Pokemon $pokemon;

    public function __construct(string $pokemonFeaturedIn, Pokemon $pokemon)
    {
        $this->pokemonFeaturedIn = $pokemonFeaturedIn;
        $this->pokemon = $pokemon;
    }

    public function handle()
    {
        DB::transaction(function () {
            $game = Game::firstOrCreate([
                'name' => $this->pokemonFeaturedIn
            ]);

            $game->pokemon()->save($this->pokemon);
        });
    }
}
