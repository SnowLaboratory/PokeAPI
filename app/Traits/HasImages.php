<?php

namespace App\Traits;

use App\Models\Image;

trait HasImages
{
    public function images ()
    {
        return $this->morphToMany(Image::class, 'model', 'has_images');
    }
}
