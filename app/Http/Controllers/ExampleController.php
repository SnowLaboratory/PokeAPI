<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\DataFetcher;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use SmeltLabs\PocketMonsters\Facades\PokeAPI;

class ExampleController extends Controller
{
    /**
     * Returns the first pae of every pokemon ever from using the ndex id numbering system.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getNationalDex() {
        $api = new EndpointBuilder();
        $baseEndpoint = $api->getAllPokemon();
        $pokemonPerPage = 24;
        $requestedPage = request()->page ?? 1;

        $url = $baseEndpoint . "?" . http_build_query([
           "limit" => $pokemonPerPage,
           "offset" => ($requestedPage - 1) * $pokemonPerPage
        ]);
        $results = Http::get($url)->json() ?? [];
        $results["maxPage"] = ceil($results["count"] / $pokemonPerPage);
        $results["prevPage"] = url()->current() . "?" . http_build_query([
            "page" => ($requestedPage > 1 ? $requestedPage - 1 : 1)
        ]);
        $results["nextPage"] = url()->current() . "?" . http_build_query([
            "page" => ($requestedPage < $results["maxPage"] ? $requestedPage + 1 : $results["maxPage"])
        ]);

        return view('nationaldex', $results);
    }
}
