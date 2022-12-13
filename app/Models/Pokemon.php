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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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

    public function types() : BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    public function weaknesses() : BelongsToMany
    {
        return $this->belongsToMany(Weakness::class);
    }

    public function abilities() : BelongsToMany
    {
        return $this->belongsToMany(Ability::class);
    }

    public function games() : BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    public function generations() : BelongsToMany
    {
        return $this->belongsToMany(Generation::class);
    }

    public function regions() : BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }

    public function habitats() : BelongsToMany
    {
        return $this->belongsToMany(Habitat::class);
    }

    public function genders() : BelongsToMany
    {
        return $this->belongsToMany(Gender::class);
    }

    public function species() : BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    public function extraEvolvesTo () : MorphMany {
        return $this->gluedWith('extraEvolvesTo')
            ->with('foreign');
    }

    public function removesEvolvesTo () : MorphMany {
        return $this->gluedWith('removesEvolvesTo')
            ->with('foreign');
    }

    public function extraEvolvesFrom () : MorphMany {
        return $this->gluedWith('extraEvolvesFrom')
            ->with('foreign');
    }

    public function removesEvolvesFrom () : MorphMany {
        return $this->gluedWith('removesEvolvesFrom')
            ->with('foreign');
    }
}
