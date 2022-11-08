<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EvolutionPath extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    public function trigger () : BelongsTo {
        return $this->belongsTo(Trigger::class);
    }

    public function evolutionChain () : BelongsTo {
        return $this->belongsTo(EvolutionChain::class);
    }
}
