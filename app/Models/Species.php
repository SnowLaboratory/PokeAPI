<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Pivot\PokedexEntry;
use App\Relations\HasManyThroughSelf;
use App\Traits\NameLookup;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Species extends Model
{
    use HasFactory, NameLookup;

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

    public function hasManyThroughSelf($model, $foreignId=null, $table=null, $localId=null, $parentId=null) {
        return new HasManyThroughSelf($this, app($model), $foreignId, $table, $localId, $parentId);
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

    // public function evolutions () {
    //     $query = $this->hasManyThrough(EvolutionChain::class, EvolutionChain::class, 'species_id', 'ec.evolveTo');

    //     // dd($query->getQuery()->getQuery()->joins);
    //     // foreach( $query->getQuery()->getQuery()->joins as $key => $join) {
    //     //     unset($query->getQuery()->getQuery()->joins[$key]);
    //     // }
    //     removeJoins($query->getQuery());

    //         $query->join('evolution_chains as ec', 'ec.id', 'evolution_chains.evolveTo')
    //         ->select(DB::raw('`ec`.*'))
    //         // ->select(DB::raw('`ec`.evolveTo, `evolution_chains`.species_id'))
    //         // ->from('evolution_chains as ec')
    //         ;

    //         return $query;
    // }
}
