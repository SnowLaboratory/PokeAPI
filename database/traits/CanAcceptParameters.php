<?php

namespace Database\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait CanAcceptParameters {

    public $parameters;
    public $rawParams;

    public function __invoke(array $parameters = [])
    {
        $this->rawParams = array_merge($this->rawParams ?? [], $parameters);
        $this->parameters = (object) $this->rawParams;
        parent::__invoke($parameters);
    }
}
