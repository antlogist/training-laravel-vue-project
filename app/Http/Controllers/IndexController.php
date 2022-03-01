<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{
    public function index() {
        return Inertia::render('Home', [
            'title' => 'Home',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

}
