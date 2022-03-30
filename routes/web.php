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
    'index'])->middleware(['auth', 'verified'])->name('notes');

Route::get('/map',
    [\App\Http\Controllers\MapController::class,
    'show'])->middleware(['auth', 'verified'])->name('map');

Route::resource('/categories', \App\Http\Controllers\CategoryController::class)
    ->middleware(['auth', 'verified'])->name('index', 'categories');


Route::get('/subcategories', [\App\Http\Controllers\SubcategoryController::class, 'index'])->
    middleware(['auth', 'verified'])->name('subcategories');

Route::get('/subcategories/create', [\App\Http\Controllers\SubcategoryController::class, 'create'])->
    middleware(['auth', 'verified'])->name('subcategories.create');

Route::post('/subcategories', [\App\Http\Controllers\SubcategoryController::class, 'store'])->
    middleware(['auth', 'verified'])->name('subcategories.store');

Route::post('/subcategories/delete/{id}', [\App\Http\Controllers\SubcategoryController::class, 'destroy'])->
    middleware(['auth', 'verified'])->name('subcategories.destroy');

Route::get('/subcategories/{subcategory}', [\App\Http\Controllers\SubcategoryController::class, 'showWithoutCategory'])->
    middleware(['auth', 'verified'])->name('subcategories.showWithoutCategory');

Route::put('/subcategories/{subcategory}', [\App\Http\Controllers\SubcategoryController::class, 'update'])->
    middleware(['auth', 'verified'])->name('subcategories.update');

Route::get('/{category}/{subcategory}', [\App\Http\Controllers\SubcategoryController::class, 'show'])->
    middleware(['auth', 'verified'])->name('subcategories.show');

Route::get('/subcategories/{subcategory}/edit', [\App\Http\Controllers\SubcategoryController::class, 'editWithoutCategory'])->
    middleware(['auth', 'verified'])->name('subcategories.editWithoutCategory');

Route::get('/{category}/{subcategory}/edit', [\App\Http\Controllers\SubcategoryController::class, 'edit'])->
    middleware(['auth', 'verified'])->name('subcategories.edit');


require __DIR__.'/auth.php';
