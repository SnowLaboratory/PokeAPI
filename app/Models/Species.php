<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Species extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pokemon () : HasMany {
        return $this->hasMany(Pokemon::class);
    }

    public function generation () : BelongsTo {
        return $this->belongsTo(Generation::class);
    }
}
