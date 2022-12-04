<?php

namespace App\Models;

use App\Traits\HasCategories;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, HasCategories, HasImages, SoftDeletes;

    public $guarded = [];

    public $timestamps = false;
}
