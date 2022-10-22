<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function generation () : BelongsTo {
        return $this->belongsTo(Generation::class);
    }

    public function pokedexes () : HasMany {
        return $this->hasMany(Pokedex::class);
    }
}
