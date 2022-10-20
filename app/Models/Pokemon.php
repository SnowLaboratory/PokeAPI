<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasImages;
use App\Traits\HasStats;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    use HasFactory, HasStats, HasCategories, HasImages;

    protected $guarded = [];

    public $timestamps = false;

    public function types()
    {
        return $this->belongsToMany(Type::class);
    }

    public function weaknesses()
    {
        return $this->belongsToMany(Weakness::class);
    }

    public function abilities()
    {
        return $this->belongsToMany(Ability::class);
    }

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function generations()
    {
        return $this->belongsToMany(Generation::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function habitats()
    {
        return $this->belongsToMany(Habitat::class);
    }

    public function genders()
    {
        return $this->belongsToMany(Gender::class);
    }

    public function evolutionChains()
    {
        return $this->hasMany(EvolutionChain::class);
    }
}
