<?php

namespace App\Traits;

use App\Models\Glue;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait InteractsWithGlue {

    public function glueResourceHelpers() : array {
        return [
            '#id' => $this->id,
            '#class' => get_class($this),
        ];
    }

    public function glue() : MorphMany
    {
        return $this->morphMany(Glue::class, 'base');
    }

    public function gluedWith($name) : MorphMany
    {
        return $this->morphMany(Glue::class, 'base')
            ->with('foreign')
            ->where('name', $name);
    }
}
