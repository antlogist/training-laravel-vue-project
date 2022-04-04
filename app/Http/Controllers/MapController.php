<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class MapController extends Controller
{
    public function show() {
        return Inertia::render('Map/Index', [
            'title' => 'Map'
        ]);
    }

}
