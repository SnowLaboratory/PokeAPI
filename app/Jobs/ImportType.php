<?php

namespace App\Jobs;

use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportType implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $pokemonTypeName;
    private Pokemon $pokemon;

    public function __construct(string $pokemonTypeName, Pokemon $pokemon )
    {
        $this->pokemonTypeName = $pokemonTypeName;
        $this->pokemon = $pokemon;
    }

    public function handle()
    {
        $type = Type::firstOrCreate([
            "name" => $this->pokemonTypeName
        ]);

        $type->pokemon()->save($this->pokemon);
    }
}
