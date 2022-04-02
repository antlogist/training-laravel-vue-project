<?php

Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index'])->
middleware(['auth', 'verified'])->name('notes');

Route::get('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'show'])->
middleware(['auth', 'verified'])->name('notes.show');
