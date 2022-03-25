<?php

namespace App\Http\Resources\Subcategory;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;

class SubcategoryIndexResource extends JsonResource
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
            'category_id' => $this->category_id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'category'    => Category::where('id', $this->category_id)->where('user_id', auth()->user()->id)->first()->showResource()
        ];
    }
}
