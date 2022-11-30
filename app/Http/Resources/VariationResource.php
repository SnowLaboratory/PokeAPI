<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...parent::toArray($request),
            'id' => $this->when($request->boolean('glue'), $this->id),
            'class' => $this->when($request->boolean('glue'), get_class($this->resource)),
        ];
    }
}
