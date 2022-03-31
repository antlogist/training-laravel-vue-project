<?php

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