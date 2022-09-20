<?php

namespace App\Models;

use App\Traits\HasCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    use HasFactory, HasCategories;

    public $timestamps = false;
}
