<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaticChainResource extends JsonResource
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
            // 'x' => ,
            // 'to' => $this->toNext($this->pokemon),
            // 'from' => $this->fromPrevious($this->pokemon)->reverse()
            'name' => $this->name,
            'evolvesTo' => ForwardChainResource::collection(
                $this->getRoot($this)->flatten()->first()->pokemon->where('is_default', true)
            )
        ];
    }

    public function getRoot($species) {
        if ($species->previous->isEmpty()) return collect([$species]);
        return $species->previous->map->species->map(
            fn($s) => $this->getRoot($s)
        );
    }

    public function from($pokemon) {
        return $pokemon->map(
            fn($variation) => [
                "name" => $variation->name,
                "from" => $this->from(
                    $variation->species->previous->map->species->map->pokemon->flatten()
                ),
            ]
        );
    }

    public function fromFlat($pokemon) {
        return $pokemon->map(
            fn($variation) => [
                $variation->toArray(),
                ...$this->fromFlat(
                    $variation->species->previous->map->species->map->pokemon->flatten()
                ),
            ]
        );
    }

    public function to($pokemon) {
        return $pokemon->map(
            fn($variation) => [
                "name" => $variation->name,
                "to" => $this->to(
                    $variation->species->next->map->species->map->pokemon->flatten()
                ),
            ]
        );
    }

    public function fromPrevious($pokemon) {
        return $this->from(
            $pokemon->map->species->map->previous->flatten()
                    ->map->species->map->pokemon->flatten()
        );
    }

    public function toNext($pokemon) {
        return $this->to(
            $pokemon->map->species->map->next->flatten()
                    ->map->species->map->pokemon->flatten()
        );
    }
}
