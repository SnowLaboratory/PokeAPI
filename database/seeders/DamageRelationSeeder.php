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


    public function syncUsing($damageRelationsJson, $damageRelationKey, $multiplier) {
        $typeNames = collect($damageRelationsJson['double_damage_from'])->pluck('name');
        $relatedTypeIds = Type::whereIn('name', $typeNames)->pluck('id');

        $dataToSync = $relatedTypeIds->keyBy(null)->map(fn($x) => [
                'multiplier' => 2
        ]);
    }

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

        $urls = Type::all()->pluck('name')->map([$api, 'getTypeByName']);

        $this->progressMap($urls, function($typeUrl)  {

            $typeJson = fetchJson($typeUrl);
            $typeDb = Type::firstWhere('name', $typeJson['name']);

            $typeDb->attachDefendingDamage('double_damage_from', 2, $typeJson);
            $typeDb->attachAttackingDamage('double_damage_to', 2, $typeJson);
            $typeDb->attachDefendingDamage('half_damage_from', 0.5, $typeJson);
            $typeDb->attachAttackingDamage('half_damage_to', 0.5, $typeJson);
            $typeDb->attachDefendingDamage('no_damage_from', 0, $typeJson);
            $typeDb->attachAttackingDamage('no_damage_to', 0, $typeJson);
        });
    }
}
