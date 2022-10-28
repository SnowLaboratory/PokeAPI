<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Pivot\PokedexEntry;

class Species extends Model
{
    use HasFactory;

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

    public function evolutionChain () : HasMany {
        return $this->hasMany(EvolutionChain::class);
    }
}
