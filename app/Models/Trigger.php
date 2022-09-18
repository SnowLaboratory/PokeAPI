<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    use HasFactory;

    public function evolutionDetails()
    {
        return $this->belongsTo(EvolutionDetails::class);
    }
}
