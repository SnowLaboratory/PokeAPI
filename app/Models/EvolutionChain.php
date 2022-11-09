<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvolutionChain extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $guarded = [];

    public function species () : BelongsTo {
        return $this->belongsTo(Species::class);
    }
}
