<?php

Route::get('/maps', [\App\Http\Controllers\MapController::class,'index'])->
middleware(['auth', 'verified'])->name('map');

Route::get('/maps/{map}/edit', [\App\Http\Controllers\MapController::class,'edit'])->
middleware(['auth', 'verified'])->name('map');
