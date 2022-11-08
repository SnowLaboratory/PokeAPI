<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function next () : HasMany {
        return $this->hasMany(EvolutionChain::class, 'evolveTo');
    }

    public function evolvesTo () {
        return $this->next()->with('evolvesTo.species');
    }

    public function previous () : HasMany {
        return $this->hasMany(EvolutionChain::class, 'evolveFrom',);
    }

    public function evolvesFrom () {
        return $this->previous()->with('evolvesFrom.species');
    }

    public function species () : BelongsTo {
        return $this->belongsTo(Species::class);
    }

    // public function speciesEvolveTo () : HasManyThrough {
    //     return $this->HasManyThrough(Species::class, EvolutionChain::class, 'species_id', 'id');
    // }

}
