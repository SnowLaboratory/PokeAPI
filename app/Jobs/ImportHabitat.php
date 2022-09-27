<?php

namespace App\Jobs;

use App\Models\Habitat;
use App\Models\Pokemon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportHabitat implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//    private Pokemon $pokemon;
//    private string $pokemonHabitat;
//
//    /**
//     * Create a new job instance.
//     *
//     * @return void
//     */
//    public function __construct(string $pokemonHabitat, Pokemon $pokemon)
//    {
//        $this->pokemonHabitat = $pokemonHabitat;
//        $this->pokemon = $pokemon;
//    }

    public function __construct(
        private string $pokemonHabitat,
        private Pokemon $pokemon
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
           $habitat = Habitat::firstOrCreate([
               'name' => $this->pokemonHabitat
           ]);
            $habitat->pokemon()->save($this->pokemon);
        });
    }
}
