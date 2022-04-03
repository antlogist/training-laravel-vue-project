<?php

Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index'])->
middleware(['auth', 'verified'])->name('notes');

Route::get('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'show'])->
middleware(['auth', 'verified'])->name('notes.show');

Route::get('/notes/{note}/edit', [\App\Http\Controllers\NoteController::class, 'edit'])->
middleware(['auth', 'verified'])->name('notes.edit');

Route::put('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'update'])->
middleware(['auth', 'verified'])->name('notes.update');
