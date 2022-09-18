<?php

namespace App\Traits;

use App\Models\Stat;

trait HasStats
{
    public function stats()
    {
        return $this->morphToMany(Stat::class, 'model', 'has_stats');
    }
}
