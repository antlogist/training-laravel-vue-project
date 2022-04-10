<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'tiles', 'user_id'];

    public function getRouteKeyName() {
        return 'slug';
    }
}
