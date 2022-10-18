<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function truncate(array $seeders) {
        $this->call($seeders, false, ['truncate' => true]);
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate([
            PokemonSeeder::class,
            SpeciesSeeder::class,
            TypeSeeder::class,
            DamageRelationSeeder::class,
            GameSeeder::class,
            GenerationSeeder::class,
            HabitatSeeder::class,
        ]);
    }
}
