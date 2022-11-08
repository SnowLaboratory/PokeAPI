<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpeciesDetailResource extends JsonResource
{
    /**
     * Transform the species model into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'capture_rate' => $this->capture_rate,
            'is_legendary' => (boolean) $this->is_legendary,
            'is_mythical' => (boolean) $this->is_mythical,
            'pokemon' => PokemonDetailResource::make($this->pokemon()->where('is_default', true)->first()),
            'variations' => PokemonDetailResource::collection($this->pokemon()->where('is_default', false)->get()),
            'evolvesTo' => ForwardChainResource::collection($this->chain->evolvesTo),
            'evolvesFrom' => BackwardChainResource::collection($this->chain->evolvesFrom),
        ];
    }
}
