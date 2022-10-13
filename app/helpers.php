<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

function fetchJson($url)
{
    if ($json = Cache::store('redis')->get($url)) return $json;
    $json = Http::get($url)->json() ?? [];
    Cache::store('redis')->put($url, $json);
    return $json;
}
