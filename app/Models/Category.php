<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\Category\CategoryShowResource;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'user_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function showResource()
    {
        return new CategoryShowResource($this);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function subcategories() {
        return $this->hasMany(Subcategory::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }
}
