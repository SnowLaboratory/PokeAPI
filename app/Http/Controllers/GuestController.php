<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpeciesDetailResource;
use App\Models\Generation;
use App\Models\Pokemon;
use App\Models\Species;

class GuestController extends Controller
{
    public function landingPage () {
        return view('welcome');
    }

    public function generationListing (Generation $generation) {
        return view('generation.index');
    }

    public function pokemonDetail (Species $species) {
        return page('pokemon.detail', SpeciesDetailResource::make($species));
    }
}
