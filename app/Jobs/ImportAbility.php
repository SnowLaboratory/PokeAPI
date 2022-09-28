<?php

namespace App\Jobs;

use App\Models\Ability;
use App\Models\Pokemon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportAbility implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private string $pokemonAbility,
        private Pokemon $pokemon
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction( function ()
        {
            $ability = Ability::firstOrCreate([
                'name' => $this->pokemonAbility
            ]);
            $ability->pokemon()->save($this->pokemon);
        });
    }
}
