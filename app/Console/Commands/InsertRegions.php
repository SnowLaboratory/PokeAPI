<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Region;

class InsertRegions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts all Pokemon Regions into the Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new EndpointBuilder();
        $baseEndpoint = $api->getAllRegions();
        $regions = Http::get($baseEndpoint)->json() ?? [];

        for ($i = 0; $i <= count($regions['results']) - 1; $i++) {
            $region = $regions['results'][$i]['name'];
            $region_name = new Region;
            $region_name->region_name = $region;
            $region_name->save();
        }
    }
}
