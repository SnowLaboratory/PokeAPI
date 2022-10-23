<?php

namespace App\Models;

use App\Traits\HasPokemon;
use App\Traits\InteractsWithDamageRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory, HasPokemon, InteractsWithDamageRelations;

    protected $guarded = [];

    public $timestamps = false;

}
