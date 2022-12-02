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
            $this->mergeWhen($request->boolean('glue'), $this->glueResourceHelpers()),
            'species' => SpeciesResource::make($this->species),
            'evolvesTo' => static::collection($this->species->next),
        ];
    }
}
