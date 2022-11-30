<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Support\Arr;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Illuminate\Support\Facades\Storage;
use Http;
use App\Models\Item;

class ItemSeeder extends Seeder
{

    use CanTruncateTables, CanDisplayProgress;

    /**
     * Run the database seeds.
     *
     * @return void
     *
     */
    public function run()
    {
        $this->truncate([
            'items'
        ]);

        $api = new EndpointBuilder();

        $url = $api->getAllItems() . "?" . http_build_query([
            "limit" => 10000,
        ]);

        $indexJson = fetchJson($url);
        $urls = collect($indexJson['results'])->pluck('url');

        $this->progressMap($urls, function($itemUrl) {

            $itemJson = fetchJson($itemUrl);
            $sprite = Arr::get($itemJson, 'sprites.default');
            $itemName = $itemJson['name'];

            $hash = sha1($sprite);
            $fileName = $hash . '.png';

            $storageUrl = tap(Storage::disk('sprites'), function($disk) use($fileName, $sprite) {
                if(!$disk->exists($fileName)) {
                    $imageData = Http::get($sprite)->body();
                    $disk->put($fileName, $imageData);
                }
            })->url($fileName);

            $item = Item::firstOrCreate(["name" => $itemName]);

            $spriteDB = $item->images()->firstOrCreate([
                'storage_url' => $storageUrl,
                'api_url' => $sprite
            ]);
        });
    }
}
