<?php

namespace Database\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait CanDisplayProgress {

    public function progressInitialize(int $count) {
        return $this->command->getOutput()->progressStart($count);
    }

    public function progressAdvance () {
        return $this->command->getOutput()->progressAdvance();
    }

    public function progressFinish () {
        return $this->command->getOutput()->progressFinish();
    }

    public function progressMap(Collection $list, callable $callback) {
        $this->progressInitialize($list->count());
        foreach($list as $key=>$value) {
            $callback($value, $key);
            $this->progressAdvance();
        }
        $this->progressFinish();
    }

}
