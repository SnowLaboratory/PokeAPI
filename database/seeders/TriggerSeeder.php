<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Traits\CanTruncateTables;
use Database\Traits\CanDisplayProgress;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Trigger;


class TriggerSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    public function run()
    {
         // 1. Truncate the table so you can run seeder by itself
         $this->truncate([
            'triggers',
        ]);

        $api = new EndpointBuilder();
        $triggerJson = fetchJson($api->getAllEvolutionTriggers());

        // 3. Loop over a list of urls associated to each trigger
        $urls = collect($triggerJson['results'])->pluck('url');
        $this->progressMap($urls, function ($triggerUrl) {

            // 4. Fetch all the data for a specific trigger
            $triggerJson = fetchJson($triggerUrl);

            // 5. Find or create a trigger model.
            $trigger = Trigger::firstOrCreate([
                "name" => $triggerJson['name'],
            ]);
        });
    }
}
