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
            'id' => $this->when($request->boolean('glue'), $this->id),
            'class' => $this->when($request->boolean('glue'), get_class($this->resource)),
            'species' => SpeciesResource::make($this->species),
            'evolvesTo' => static::collection($this->species->next),
        ];
    }
}
