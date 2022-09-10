<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use App\Models\Generation;

class InsertGenerations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:generations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts all of the generations into the database';

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
        $baseEndpoint = $api->getAllGenerations();
        $generations = Http::get($baseEndpoint)->json() ?? [];

        for ($i = 0; $i <= count($generations['results']) - 1; $i++) {
            $gen = $generations['results'][$i]['name'];
            $gen_name = new Generation;
            $gen_name->generation_name = $gen;
            $gen_name->save();
        }
    }
}
