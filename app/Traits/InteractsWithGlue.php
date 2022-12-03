<?php

namespace App\Traits;

use App\Models\Glue;

trait InteractsWithGlue {

    public function glueResourceHelpers() : array {
        return [
            '#id' => $this->id,
            '#class' => get_class($this),
        ];
    }

    public function glue() {
        return $this->morphMany(Glue::class, 'base');
    }

    public function gluedWith($name) {
        return $this->morphMany(Glue::class, 'base')
            ->with('foreign')
            ->where('name', $name);
    }
}
