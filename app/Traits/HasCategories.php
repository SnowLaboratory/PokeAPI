<?php

namespace App\Traits;

use App\Models\Category;

trait HasCategories
{
    public function category()
    {
        return $this->morphToMany(Category::class, 'model', 'has_categories');
    }
}
