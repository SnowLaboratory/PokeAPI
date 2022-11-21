<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasMetas;
class EvolutionChain extends Model
{
    use HasFactory, HasMetas;

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
