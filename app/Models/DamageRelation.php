<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DamageRelation extends Pivot
{
    protected $guarded = [];
    public $timestamps = false;

    protected $foreignKey = 'attacking_type_id';
    protected $relatedKey = 'defending_type_id';
    protected $table = 'damage_relation';
}
