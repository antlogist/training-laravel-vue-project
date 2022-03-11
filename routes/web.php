<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/',
    [\App\Http\Controllers\IndexController::class,
    'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// If page doesn't need a corresponding controller method
// Route::get('/notes', function () {
//     return Inertia::render('Notes');
// })->middleware(['auth', 'verified'])->name('note');

Route::get('/notes',
    [\App\Http\Controllers\NoteController::class,
    'show'])->name('notes');

// Route::inertia('/welcome', 'Welcome');

require __DIR__.'/auth.php';
