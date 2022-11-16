<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeciesDetailResource;
use App\Models\Generation;
use App\Models\Pokemon;
use App\Models\Species;
use Inertia\Inertia;

class GuestController extends Controller
{
    public function landingPage () {
        return view('welcome');
    }

    public function generationListing (Generation $generation) {
        return view('generation.index');
    }

    public function pokemonDetail (Species $species) {
        return Inertia::resource('Pokemon/Detail', SpeciesDetailResource::make($species));
        return page('pokemon.detail', SpeciesDetailResource::make($species));
    }
}
