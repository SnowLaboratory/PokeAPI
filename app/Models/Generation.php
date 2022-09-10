<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;

    protected $fillable = [
        'generation_name'
    ];
    public $timestamps = false;

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
