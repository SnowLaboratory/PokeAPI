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
            $this->mergeWhen($request->boolean('glue'), $this->glueResourceHelpers()),
            'name' => $this->name,
            'capture_rate' => $this->capture_rate,
            'is_legendary' => (boolean) $this->is_legendary,
            'is_mythical' => (boolean) $this->is_mythical,
            'pokemon' => PokemonStubResource::make($this->pokemon()->where('is_default', true)->first()),
            'variations' => PokemonStubResource::collection($this->pokemon()->where('is_default', false)->get())
        ];
    }
}
