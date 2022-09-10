<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_name'
    ];
    public $timestamps = false;

    public function pokemon()
    {
        return $this->hasMany(Pokemon::class);
    }
}
