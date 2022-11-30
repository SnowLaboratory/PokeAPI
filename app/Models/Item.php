<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, HasCategories, HasImages;

    public $guarded = [];

    public $timestamps = false;
}
