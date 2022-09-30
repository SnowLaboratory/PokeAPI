<?php

namespace App\Models;

use App\Traits\HasPokemon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory, HasPokemon;

    protected $guarded = [];

    public $timestamps = false;

    public function damageRelations()
    {
        return $this->belongsToMany(Type::class, 'damage_relation', 'attacking_type_id', 'defending_type_id')->using(DamageRelation::class);
    }

}
