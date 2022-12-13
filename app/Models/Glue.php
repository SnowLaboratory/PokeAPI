<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Glue extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    public $table = 'glue';

    public $casts = [
        'data' => 'array',
    ];

    public function base() : MorphTo {
        return $this->morphTo('base');
    }

    public function foreign() : MorphTo {
        return $this->morphTo('foreign');
    }
}
