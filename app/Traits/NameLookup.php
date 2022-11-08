<?php

namespace App\Traits;

trait NameLookup
{
    public function getRouteKeyName(){
        return 'name';
    }

    // public function getKeyName() {
    //     return 'name';
    // }

    public function scopeNamed($query, $name) {
        return $query->firstWhere('name', $name);
    }
}
