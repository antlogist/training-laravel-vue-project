<?php

Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index'])->
middleware(['auth', 'verified'])->name('notes');
