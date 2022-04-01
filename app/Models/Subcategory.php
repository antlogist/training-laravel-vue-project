<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Subcategory\SubcategoryShowResource;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'user_id', 'category_id'];

    public function getRouteKeyName() {
        return 'slug';
    }

    public function showResource() {
        return new SubcategoryShowResource($this);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }
}
