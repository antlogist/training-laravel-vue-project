<?php

namespace App\Http\Resources\Map;

use Illuminate\Http\Resources\Json\JsonResource;

class MapShowResource extends JsonResource
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
        'id'          => $this->id,
        'title'       => $this->title,
        'slug'        => $this->slug,
        'tiles'       => $this->tiles
      ];
    }
}