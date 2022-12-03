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
            $this->mergeWhen($request->boolean('glue'), $this->glueResourceHelpers()),
            "is_default" => $this->is_default,
            "name" => $this->name,
            "weight" => $this->weight,
            "height" => $this->height,
            "formatted_name" => str($this->name)->headline()->value(),
            'evolvesTo' => ForwardChainResource::collection(
                $this->species->next->map->species->map->pokemon->flatten()
                ->merge($this->extraEvolvesTo->pluck('foreign'))
                ->diff($this->removesEvolvesTo->pluck('foreign'))
            ),
            'evolvesFrom' => BackwardChainResource::collection(
                $this->species->previous->map->species->map->pokemon->flatten()
                ->merge($this->extraEvolvesFrom->pluck('foreign'))
                ->diff($this->removesEvolvesFrom->pluck('foreign'))
            ),
            // 'evolvesFrom' => BackwardChainResource::collection($this->species->previous),
            ...$this->getImages(),
            // "stats" => [],
            // "sprites" => [],
            // "growth_rate" => [
            //     "name" => null,
            // ],
            // "pokedex" => [
            //     "indices" => [],
            // ],
            // "types" => [],
            // "ability" => [
            //     "name" => null,
            // ],
            // "evolution" => [
            //     "details" => [
            //         "meta" => [],
            //         "trigger" => [
            //             "name" => null,
            //         ],
            //     ],
            // ],
            // "generation" => [
            //     "name" => null,
            //     "main_region" => [
            //         "name" => null,
            //     ],
            // ],
            // "habitat" => [
            //     "name" => null,
            // ],
        ];
    }

    public function getImages ()
    {
        return [
            "images" => ImageResource::collection($this->images),
        ];
    }
}
