<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpeciesResource extends JsonResource
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
            'pokemon' => PokemonStubResource::collection($this->pokemon),
        ];
    }
}
