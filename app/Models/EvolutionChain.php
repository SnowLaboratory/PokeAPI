<?php

namespace App\Models;

use App\Interfaces\Glue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasMetas;
use App\Traits\InteractsWithGlue;

class EvolutionChain extends Model implements Glue
{
    use HasFactory, HasMetas, InteractsWithGlue;

    public $timestamps = false;

    public $guarded = [];

    public function species () : BelongsTo {
        return $this->belongsTo(Species::class);
    }

    public function getItemsAttribute (){
        $ids = collect($this->meta)->pluck('value.id');
        return Item::whereIn('id', $ids)->get();

    }
}
