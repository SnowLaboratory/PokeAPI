<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\DamageRelation;
use App\Models\Type;
use SmeltLabs\PocketMonsters\EndpointBuilder;

trait InteractsWithDamageRelations
{
    public function attackingDamageRelations()
    {
        return $this->belongsToMany(Type::class, 'damage_relation', 'attacking_type_id', 'defending_type_id')
            ->using(DamageRelation::class);
    }

    public function defendingDamageRelations()
    {
        return $this->belongsToMany(Type::class, 'damage_relation', 'defending_type_id', 'attacking_type_id')
            ->using(DamageRelation::class);
    }

    public function usingDamageSync($key, $multiplier, $typeJson=null) {
        $api = new EndpointBuilder();
        $typeJsonUrl = $api->getTypeByName($this->name);
        $typeJson = $typeJson ?? fetchJson($typeJsonUrl);
        $damageRelationsJson = $typeJson['damage_relations'];
        $typeNames = collect($damageRelationsJson[$key])->pluck('name');
        $relatedTypeIds = static::whereIn('name', $typeNames)->pluck('id');

        return $relatedTypeIds->keyBy(null)->map(fn($x) => [
                'multiplier' => $multiplier,
        ]);
    }

    public function syncAttackingDamage($key, $multiplier, $typeJson=null) {
        $dataToSync = $this->usingDamageSync($key, $multiplier, $typeJson);
        $this->attackingDamageRelations()->sync($dataToSync);
    }

    public function syncDefendingDamage($key, $multiplier, $typeJson=null) {
        $dataToSync = $this->usingDamageSync($key, $multiplier, $typeJson);
        $this->defendingDamageRelations()->sync($dataToSync);
    }

    public function attachAttackingDamage($key, $multiplier, $typeJson=null) {
        $dataToSync = $this->usingDamageSync($key, $multiplier, $typeJson);
        $this->attackingDamageRelations()->attach($dataToSync);
    }

    public function attachDefendingDamage($key, $multiplier, $typeJson=null) {
        $dataToSync = $this->usingDamageSync($key, $multiplier, $typeJson);
        $this->defendingDamageRelations()->attach($dataToSync);
    }
}
