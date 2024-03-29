<?php

namespace App\Models;

use App\Interfaces\Glue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Pivot\PokedexEntry;
use App\Relations\HasManyThroughSelf as RelationsHasManyThroughSelf;
use App\Traits\HasManyThroughSelf;
use App\Traits\InteractsWithGlue;
use App\Traits\NameLookup;
use Illuminate\Database\Eloquent\SoftDeletes;

class Species extends Model implements Glue
{
    use HasFactory,
     NameLookup,
     HasManyThroughSelf,
     InteractsWithGlue,
     SoftDeletes;

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

    public function chains () :HasMany {
        return $this->hasMany(EvolutionChain::class);
    }

    public function next () : RelationsHasManyThroughSelf
    {
        return $this->hasManyThroughSelf(EvolutionChain::class, 'evolveTo');
    }

    public function evolvesTo () : RelationsHasManyThroughSelf
    {
        return $this->next()->with('species.evolvesTo');
    }

    public function previous () : RelationsHasManyThroughSelf
    {
        return $this->hasManyThroughSelf(EvolutionChain::class, 'evolveFrom');
    }

    public function evolvesFrom () : RelationsHasManyThroughSelf
    {
        return $this->previous()->with('species.evolvesFrom');
    }
}
