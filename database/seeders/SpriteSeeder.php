<?php

namespace Database\Seeders;

use App\Models\Sprite;
use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Http;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use SmeltLabs\PocketMonsters\EndpointBuilder;

class SpriteSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
        $this->truncate([
            'sprites'
        ]);

        $api = new EndpointBuilder();

        $url = $api->getAllPokemon() . "?" . http_build_query([
            "limit" => 10000,
        ]);

        $indexJson = fetchJson($url);
        $urls = collect($indexJson['results'])->pluck('url');

        $this->progressMap($urls, function($pokemonUrl) {

            $pokemonJson = fetchJson($pokemonUrl);

            $sprite = $pokemonJson['sprites'];

            $originalArtworkUrl = $sprite['other']['official-artwork']['front_default'];

            $imageData = Http::get($originalArtworkUrl)->body();
            $hash = sha1($imageData);
            $filename = $hash . '.png';
            $image = Storage::disk('sprites')->put($filename, $imageData);
            $storageUrl = Storage::disk('sprites')->url($filename);
            dd($storageUrl);

            // Sprite::firstOrCreate([
            //     'name' => $pokemonJson['name'],
            // ]);

        });
    }

}
