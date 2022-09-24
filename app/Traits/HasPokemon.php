<?php

namespace App\Traits;

use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPokemon
{
    public function pokemon() : BelongsToMany
    {
        return $this->belongsToMany(Pokemon::class);
    }
}
