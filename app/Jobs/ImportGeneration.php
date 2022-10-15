<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Pokemon;
use App\Models\Generation;
use Illuminate\Support\Facades\DB;

class ImportGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $gameGeneration;
    private Pokemon $pokemon;

    public function __construct(string $gameGeneration, Pokemon $pokemon)
    {
        $this->gameGeneration = $gameGeneration;
        $this->pokemon = $pokemon;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::Transaction( function() {
            $generation = Generation::firstOrCreate([
                "name" => $this->gameGeneration
            ]);

            $generation->pokemon()->save($this->pokemon);
        });
    }
}
