<?php

namespace Database\Seeders;

use App\Models\DamageRelation;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use SmeltLabs\PocketMonsters\EndpointBuilder;

class DamageRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         *step 1 fetch all pokemon types from the db
         *step 2 loop over each pokemon type
         * step 3 get all damage relation data for current type from api
         * step 4 loop over api data to get existing database records for current pokemon type
         * step 5 save
         */

        $api = new EndpointBuilder();

        foreach (Type::all() as $pokemonTypeDB)
        {
            $url = $api->getTypeByName($pokemonTypeDB->name);

            $damageRelation = fetchJson($url)['damage_relations'];

            foreach ($damageRelation['double_damage_from'] as $pokemonTypeApi)
            {
                $damage = Type::where('name', $pokemonTypeApi['name'])->firstOrFail();

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $pokemonTypeDB->id,
                    'defending_type_id' => $damage->id,
                    'multiplier' => 2
                ]);

            }

            foreach ($damageRelation['double_damage_to'] as $pokemonTypeApi)
            {

                $damage = Type::where('name', $pokemonTypeApi['name'])->firstORFail();

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $damage->id,
                    'defending_type_id' => $pokemonTypeDB->id,
                    'multiplier' => 2
                ]);

            }

            foreach ($damageRelation['half_damage_from'] as $pokemonTypeApi)
            {
                $damage = Type::where('name', $pokemonTypeApi['name'])->firstORFail();

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $pokemonTypeDB->id,
                    'defending_type_id' => $damage->id,
                    'multiplier' => 0.5
                ]);

            }

            foreach ($damageRelation['half_damage_to'] as $pokemonTypeApi)
            {
                $damage = Type::where('name', $pokemonTypeApi['name'])->firstORFail();

                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $damage->id,
                    'defending_type_id' => $pokemonTypeDB->id,
                    'multiplier' => 0.5
                ]);
            }

            foreach ($damageRelation['no_damage_from'] as $pokemonTypeApi)
            {
                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $pokemonTypeDB->id,
                    'defending_type_id' => $damage->id,
                    'multiplier' => 0
                ]);
            }

            foreach ($damageRelation['no_damage_to'] as $pokemonTypeApi)
            {
                DamageRelation::firstOrCreate([
                    'attacking_type_id' => $damage->id,
                    'defending_type_id' => $pokemonTypeDB->id,
                    'multiplier' => 0
                ]);
            }



//            dd($damageRelation['double_damage_from']);
        }


    }
}
