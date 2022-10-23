<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class EvolutionChain extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    // public function evolutionDetails()
    // {
    //     return $this->hasOne(EvolutionDetails::class);
    // }

    public function evolveTo () : HasMany {
        return $this->hasMany(EvolutionChain::class, 'evolveTo');
    }

    public function evolveFrom () : HasMany {
        return $this->hasMany(EvolutionChain::class, 'evolveFrom');
    }

    public function species () : BelongsTo {
        return $this->belongsTo(Species::class);
    }

    // public function speciesEvolveTo () : HasManyThrough {
    //     return $this->HasManyThrough(Species::class, EvolutionChain::class, 'species_id', 'id');
    // }

}
