<?php

Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index'])->
middleware(['auth', 'verified'])->name('notes');

Route::get('/notes/create', [\App\Http\Controllers\NoteController::class, 'create'])->
middleware(['auth', 'verified'])->name('notes.create');

Route::post('/notes', [\App\Http\Controllers\NoteController::class, 'store'])->
middleware(['auth', 'verified'])->name('notes.store');

Route::post('/notes/delete/{note}', [\App\Http\Controllers\NoteController::class, 'destroy'])->
middleware(['auth', 'verified'])->name('notes.destroy');

Route::get('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'show'])->
middleware(['auth', 'verified'])->name('notes.show');

Route::get('/notes/{note}/edit', [\App\Http\Controllers\NoteController::class, 'edit'])->
middleware(['auth', 'verified'])->name('notes.edit');

Route::put('/notes/{note}', [\App\Http\Controllers\NoteController::class, 'update'])->
middleware(['auth', 'verified'])->name('notes.update');
