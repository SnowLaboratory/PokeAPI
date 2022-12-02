<?php

namespace App\Models;

use App\Interfaces\Glue;
use App\Traits\InteractsWithGlue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model implements Glue
{
    use HasFactory, InteractsWithGlue;

    public $timestamps = false;
}
