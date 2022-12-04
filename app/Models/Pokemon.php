<?php

namespace App\Models;

use App\Interfaces\Glue;
use App\Traits\HasCategories;
use App\Traits\HasImages;
use App\Traits\HasStats;
use App\Traits\InteractsWithGlue;
use App\Traits\NameLookup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pokemon extends Model implements Glue
{
    use HasFactory,
        HasStats,
        HasCategories,
        HasImages,
        InteractsWithGlue,
        NameLookup,
        SoftDeletes;

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

    public function species() {
        return $this->belongsTo(Species::class);
    }

    public function extraEvolvesTo () {
        return $this->gluedWith('extraEvolvesTo')
            ->with('foreign');
    }

    public function removesEvolvesTo () {
        return $this->gluedWith('removesEvolvesTo')
            ->with('foreign');
    }

    public function extraEvolvesFrom () {
        return $this->gluedWith('extraEvolvesFrom')
            ->with('foreign');
    }

    public function removesEvolvesFrom () {
        return $this->gluedWith('removesEvolvesFrom')
            ->with('foreign');
    }
}
