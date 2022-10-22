<?php

namespace App\Models;

use App\Models\Pivot\PokedexEntry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pokedex extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function species() : BelongsToMany {
       return $this->belongsToMany(Species::class)->using(PokedexEntry::class)->withPivot(['entry_number']);
    }

    public function region() : BelongsTo {
        return $this->belongsTo(Region::class);
    }
}
