<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PokedexEntry extends Pivot
{
    protected $guarded = [];

    public $timestamps = false;

    protected $pivotColumns = ['entry_number'];

}
