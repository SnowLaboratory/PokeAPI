<?php

namespace App\Traits;

use App\Models\Pokedex;

trait HasPokedex
{
    public function pokedex()
    {
        return $this->morphToMany(Pokedex::class, 'model', 'has_pokedexes');
    }
}
