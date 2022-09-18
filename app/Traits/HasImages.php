<?php

namespace App\Traits;

use App\Models\Image;

trait HasImages
{
    public function image()
    {
        return $this->morphToMany(Image::class, 'model', 'has_images');
    }
}
