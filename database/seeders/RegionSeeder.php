<?php

namespace Database\Seeders;

use Database\Traits\CanDisplayProgress;
use Database\Traits\CanTruncateTables;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Pokedex;
use App\Models\Region;
use App\Models\Generation;

class RegionSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
        // 1. Truncate the table so you can run seeder by itself
        $this->truncate([
            'regions',
            // 'region_release',
        ]);

        // 2. Fetch all the regions from the API
        $api = new EndpointBuilder();
        $infoJson = fetchJson($api->getAllRegions());

        // 3. Loop over a list of urls associated to each regions
        $urls = collect($infoJson['results'])->pluck('url');

        $this->progressMap($urls, function($regionUrl) {

            // 4. Fetch all the data for a specific region
            $regionJson = fetchJson($regionUrl);

            // 5. Assign variables for easy access.
            $regionName = $regionJson['name'];
            $generationName = optional($regionJson['main_generation'])['name'];

            // 6. Save region name to DB
            $region = Region::firstOrCreate([
                'name' => $regionName,
            ]);

            // 7. Get Pokedex Names
            $pokedexNames = collect($regionJson['pokedexes'])->pluck('name');

            // 8. Get Pokedex ids where row has a name inside the pokedexNames variable
            $pokedexes = Pokedex::whereIn('name', $pokedexNames)->get();

            // 9. Wipes current pokedex relationship and attaches pokedexes with matching ids
            $region->pokedexes()->saveMany($pokedexes);

            // 10. if statement to see if generationName is set
            if (isset($generationName)) {
                $generationDB = Generation::firstWhere('name', $generationName);
                // $generationDB->region()->save($region);
                $region->generation()->associate($generationDB)->save();
            };
        });
    }
}
