<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Subcategory;
use App\Models\Category;
use App\Http\Resources\Subcategory\SubcategoryByCategoryShowResource;

class CategoryShowResource extends JsonResource
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
            'subcategories' => SubcategoryByCategoryShowResource::collection(
                Category::find($this->id)->subcategories->where('user_id', auth()->user()->id)
            )
        ];
    }
}
