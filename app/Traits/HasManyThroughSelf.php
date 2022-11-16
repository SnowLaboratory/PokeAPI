<?php

namespace App\Traits;

use App\Relations\HasManyThroughSelf as Relationship;

trait HasManyThroughSelf
{
    public function hasManyThroughSelf($model, $foreignId=null, $table=null, $localId=null, $parentId=null) {
        return new Relationship($this, app($model), $foreignId, $table, $localId, $parentId);
    }
}
