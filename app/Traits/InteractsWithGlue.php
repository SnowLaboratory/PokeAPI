<?php

namespace App\Traits;

trait InteractsWithGlue {

    public function glueResourceHelpers() : array {
        return [
            '#id' => $this->id,
            '#class' => get_class($this),
        ];
    }

}
