<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Subcategory\subcategoryByCategoryShowResource;

class Subcategory extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function subcategoryByCategoryShowResource()
    {
        return new SubcategoryByCategoryShowResource($this);
    }
}
