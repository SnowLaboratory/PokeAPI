<?php

namespace App\Models;

use App\Traits\HasPokemon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Generation extends Model
{
    use HasFactory, HasPokemon;

    public $guarded = [];

    public $timestamps = false;


    public function region () : HasOne {
        return $this->hasOne(Region::class);
    }
}
