<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Pokemon;
use App\Models\Species;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard () {
        return Inertia::resource('Admin/Dashboard/Index', [
            'species' => Species::count(),
            'pokemon' => Pokemon::count(),
            'items' => Item::count(),
        ]);
    }
}
