<?php

namespace App\Traits;

use App\Models\Pokemon;

trait HasPokemon
{
    public function pokemon()
    {
        return $this->belongsToMany(Pokemon::class);
    }
}
