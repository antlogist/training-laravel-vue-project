<?php

namespace App\Http\Resources\Note;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;
use App\Models\Subcategory;

class NoteIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $arrayData = [
            'id'          => $this->id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'title'       => $this->title,
            'slug'        => $this->slug,
        ];

        if($this->category_id !== null) {
            $arrayData['category'] = Category::where('id', $this->category_id)->where('user_id', auth()->user()->id)->first()->showResource();
        }

        if($this->subcategory_id !== null) {
          $arrayData['subcategory'] = Subcategory::where('id', $this->subcategory_id)->where('user_id', auth()->user()->id)->first()->showResource();
      }

        return $arrayData;
    }
}
