<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sprite extends Model
{
    use HasFactory;

    public $guarded = [];
    public $timestamps = false;

    public function pokemon () : BelongsTo {
        return $this->belongsTo(Pokemon::class);
    }
}
