<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PokemonStubResource extends JsonResource
{
    /**
     * Transform the pokemon model into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this->name);
        return [
            $this->mergeWhen($request->boolean('glue'), $this->glueResourceHelpers()),
            "name" => $this->name,
            "species" => $this->species->name,
            "images" => ImageResource::collection($this->images),
            'evolvesTo' => ForwardChainResource::collection(
                $this->whenAppended(
                    'forward',
                    $this->species->next->map->species->map->pokemon->flatten()
                    ->merge($this->extraEvolvesTo->pluck('foreign'))
                    ->diff($this->removesEvolvesTo->pluck('foreign'))
                )
            ),
            'evolvesFrom' => BackwardChainResource::collection(
                $this->whenAppended(
                    'backward',
                    $this->species->previous->map->species->map->pokemon->flatten()
                    ->merge($this->extraEvolvesFrom->pluck('foreign'))
                    ->diff($this->removesEvolvesFrom->pluck('foreign'))
                )
            ),
        ];
    }
}
