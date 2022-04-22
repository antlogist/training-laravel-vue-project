<?php

Route::get('/maps', [\App\Http\Controllers\MapController::class,'index'])->
middleware(['auth', 'verified'])->name('maps');

Route::get('/maps/create', [\App\Http\Controllers\MapController::class, 'create'])->
middleware(['auth', 'verified'])->name('maps.create');

Route::post('/maps', [\App\Http\Controllers\MapController::class, 'store'])->
middleware(['auth', 'verified'])->name('maps.store');

Route::post('/maps/delete/{map}', [\App\Http\Controllers\MapController::class, 'destroy'])->
middleware(['auth', 'verified'])->name('maps.destroy');

Route::get('/maps/{map}', [\App\Http\Controllers\MapController::class, 'show'])->
middleware(['auth', 'verified'])->name('maps.show');

Route::get('/maps/{map}/edit', [\App\Http\Controllers\MapController::class,'edit'])->
middleware(['auth', 'verified'])->name('maps.edit');

Route::put('/maps/{map}', [\App\Http\Controllers\MapController::class, 'update'])->
middleware(['auth', 'verified'])->name('maps.update');
