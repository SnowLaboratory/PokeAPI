<?php

namespace App\Models;

use App\Traits\HasPokemon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory, HasPokemon;

    public $timestamps = false;
}
