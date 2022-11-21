<?php

namespace App\Traits;

use App\Models\Meta;

trait HasMetas
{
    public function meta ()
    {
        return $this->morphToMany(Meta::class, 'model', 'has_metas');
    }
}
