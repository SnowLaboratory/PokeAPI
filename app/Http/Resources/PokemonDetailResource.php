<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PokemonDetailResource extends JsonResource
{
    /**
     * Transform the pokemon model into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "is_default" => $this->is_default,
            "name" => $this->name,
            "weight" => $this->weight,
            "height" => $this->height,
            "stats" => [],
            "sprites" => [],
            "growth_rate" => [
                "name" => null,
            ],
            "pokedex" => [
                "indices" => [],
            ],
            "types" => [],
            "ability" => [
                "name" => null,
            ],
            "evolution" => [
                "details" => [
                    "meta" => [],
                    "trigger" => [
                        "name" => null,
                    ],
                ],
            ],
            "generation" => [
                "name" => null,
                "main_region" => [
                    "name" => null,
                ],
            ],
            "habitat" => [
                "name" => null,
            ],
        ];
    }
}
