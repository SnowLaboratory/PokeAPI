<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glue extends Model
{
    use HasFactory;

    public $guarded = [];

    public $timestamps = false;

    public $table = 'glue';

    public $casts = [
        'data' => 'array',
    ];

    public function base() {
        return $this->morphTo('base');
    }

    public function foreign() {
        return $this->morphTo('foreign');
    }
}
