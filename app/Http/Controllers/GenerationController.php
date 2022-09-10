<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\DataFetcher;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use SmeltLabs\PocketMonsters\Facades\PokeAPI;
use App\Models\Pokemon;

class GenerationController extends  Controller
{
    /**
     *Returns pokemon based on their generation. main series only
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected $gen;

    public function getGeneration($gen)
    {
        $api = new EndpointBuilder();
        $baseEndpoint = $api->getGenerationByName($gen);
        $results = Http::get($baseEndpoint)->json() ?? [];


        return view('kanto', compact('results'));
    }


}
