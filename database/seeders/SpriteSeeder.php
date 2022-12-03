<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Http;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Pokemon;
use Illuminate\Support\Arr;

class SpriteSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'images',
        ]);

        $api = new EndpointBuilder();

        $url = $api->getAllPokemon() . "?" . http_build_query([
            "limit" => 10000,
        ]);

        $indexJson = fetchJson($url);
        $urls = collect($indexJson['results'])->pluck('url');

        $this->progressMap($urls, function($pokemonUrl) {

            $pokemonJson = fetchJson($pokemonUrl);
            $pokemonName = $pokemonJson['name'];
            $sprite = $pokemonJson['sprites'];

            $originalArtworkUrl = Arr::get($sprite, 'other.official-artwork.front_default');
            $frontDefault = $sprite['front_default'];
            $hash = sha1($originalArtworkUrl);
            $fileName = $hash . '.png';

            $storageUrl = tap(Storage::disk('sprites'), function($disk) use($fileName, $originalArtworkUrl, $frontDefault) {
                if(!$disk->exists($fileName)) {
                    $imageData = Http::get($originalArtworkUrl ?? $frontDefault)->body();
                    $disk->put($fileName, $imageData);
                }
            })->url($fileName);

            $pokemon = Pokemon::firstWhere('name', $pokemonName);

            $spriteDB = $pokemon->images()->firstOrCreate([
                'storage_url' => $storageUrl,
                'api_url' => $originalArtworkUrl
            ]);
        });
    }

}
