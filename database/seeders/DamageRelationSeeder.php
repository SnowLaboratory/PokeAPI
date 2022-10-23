<?php

namespace Database\Seeders;

use App\Models\DamageRelation;
use App\Models\Type;
use Illuminate\Database\Seeder;
use SmeltLabs\PocketMonsters\EndpointBuilder;
use Database\Traits\CanTruncateTables;
use Database\Traits\CanDisplayProgress;

class DamageRelationSeeder extends Seeder
{
    use CanTruncateTables, CanDisplayProgress;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Truncate the table so you can run seeder by itself
        $this->truncate([
            'damage_relation'
        ]);

        $api = new EndpointBuilder();

        $this->progressMap(Type::all(), function($pokemonTypeDB) use($api) {
            $url = $api->getTypeByName($pokemonTypeDB->name);

            $damageRelation = fetchJson($url)['damage_relations'];

            foreach ($damageRelation['double_damage_from'] as $pokemonTypeApi)
            {
                $damage = Type::firstWhere('name', $pokemonTypeApi['name']);

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $damage->id,
                    'defending_type_id' => $pokemonTypeDB->id,
                    'multiplier' => 2
                ]);

            }

            foreach ($damageRelation['double_damage_to'] as $pokemonTypeApi)
            {

                $damage = Type::firstWhere('name', $pokemonTypeApi['name']);

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $pokemonTypeDB->id,
                    'defending_type_id' => $damage->id,
                    'multiplier' => 2
                ]);

            }

            foreach ($damageRelation['half_damage_from'] as $pokemonTypeApi)
            {
                $damage = Type::firstWhere('name', $pokemonTypeApi['name']);

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $damage->id,
                    'defending_type_id' => $pokemonTypeDB->id,
                    'multiplier' => 0.5
                ]);

            }

            foreach ($damageRelation['half_damage_to'] as $pokemonTypeApi)
            {
                $damage = Type::firstWhere('name', $pokemonTypeApi['name']);

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $pokemonTypeDB->id,
                    'defending_type_id' => $damage->id,
                    'multiplier' => 0.5
                ]);
            }

            foreach ($damageRelation['no_damage_from'] as $pokemonTypeApi)
            {
                $damage = Type::firstWhere('name', $pokemonTypeApi['name']);
                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $damage->id,
                    'defending_type_id' => $pokemonTypeDB->id,
                    'multiplier' => 0
                ]);
            }

            foreach ($damageRelation['no_damage_to'] as $pokemonTypeApi)
            {
                $damage = Type::firstWhere('name', $pokemonTypeApi['name']);
                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $pokemonTypeDB->id,
                    'defending_type_id' => $damage->id,
                    'multiplier' => 0
                ]);
            }
        });
    }
}
