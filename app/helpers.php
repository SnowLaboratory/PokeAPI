<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

function fetchJson($url)
{
    if ($json = Cache::store('redis')->get($url)) return $json;
    $json = Http::get($url)->json() ?? [];
    Cache::store('redis')->put($url, $json);
    return $json;
}

/**
 * Return a view or json with limited data specified by a resource.
 */
function page($view, JsonResource $jsonResource) {
    return response()->resource($view, $jsonResource);
}

function when($value, $callback, ...$extraArgs) {
    if(!isset($value) || !$value) return;
    if (is_callable($callback)) {
        return call_user_func($callback, $value, ...$extraArgs);
    }
    return $callback;
}
