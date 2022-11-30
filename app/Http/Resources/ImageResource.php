<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id' => $this->when($request->boolean('glue'), $this->id),
            'class' => $this->when($request->boolean('glue'), get_class($this->resource)),
            'url' => $this->storage_url,
            'fallback_url' => $this->api_url,
        ];
    }
}
