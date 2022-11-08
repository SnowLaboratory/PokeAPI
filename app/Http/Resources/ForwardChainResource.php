<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ForwardChainResource extends JsonResource
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
            'species' => SpeciesResource::make($this->species),
            'evolvesTo' => static::collection($this->evolvesTo),
        ];
    }
}
