<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Pivot\PokedexEntry;
use App\Traits\HasManyThroughSelf;
use App\Traits\NameLookup;

class Species extends Model
{
    use HasFactory, NameLookup, HasManyThroughSelf;

    protected $guarded = [];

    public $timestamps = false;

    public function pokemon () : HasMany {
        return $this->hasMany(Pokemon::class);
    }

    public function generation () : BelongsTo {
        return $this->belongsTo(Generation::class);
    }

    public function habitat () : BelongsTo {
        return $this->belongsTo(habitat::class);
    }

    public function pokedex () : BelongsToMany {
        return $this->belongsToMany(Pokedex::class)->using(PokedexEntry::class)->withPivot('entry_number');
    }

    public function chains () {
        return $this->hasMany(EvolutionChain::class);
    }

    public function next () {
        return $this->hasManyThroughSelf(EvolutionChain::class, 'evolveTo');
    }

    public function evolvesTo () {
        return $this->next()->with('species.evolvesTo');
    }

    public function previous () {
        return $this->hasManyThroughSelf(EvolutionChain::class, 'evolveFrom');
    }

    public function evolvesFrom () {
        return $this->previous()->with('species.evolvesFrom');
    }
}
