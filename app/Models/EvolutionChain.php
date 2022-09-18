<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvolutionChain extends Model
{
    use HasFactory;

    public function evolutionDetails()
    {
        return $this->hasOne(EvolutionDetails::class);
    }

    public function evolvesFrom()
    {
        return $this->belongsTo(Pokemon::class, 'evolves_from_id');
    }

    public function evolvesTo()
    {
        return $this->belongsTo(Pokemon::class, 'evolves_to_id');
    }

    public function pokemon()
    {
        return $this->belongsTo(Pokemon::class, 'pokemon_id');
    }
}
