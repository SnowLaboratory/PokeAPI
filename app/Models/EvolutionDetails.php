<?php

namespace App\Models;

use App\Traits\HasMetas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvolutionDetails extends Model
{
    use HasFactory, HasMetas;

    public function trigger() {
        return $this->hasOne(Trigger::class);
    }
}
