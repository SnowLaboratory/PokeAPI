<?php

namespace App\Models;

use App\Traits\HasPokemon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitat extends Model
{
    use HasFactory, HasPokemon;

    public $guarded = [];

    public $timestamps = false;

    public function species () : HasMany {
        return $this->hasMany(Species::class);
    }
}
