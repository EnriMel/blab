<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlabController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OpenAISuggestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'verified'])->group(function() {
//     Route::get('blabs', [BlabController::class, 'index'])->name('blabs.index');
//     Route::post('blabs', [BlabController::class, 'store'])->name('blabs.store');
// });

// all blabs and store new blab
Route::resource('blabs', BlabController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);


// suggests with gpt
Route::post('/blabs/suggest', [OpenAISuggestionController::class, 'suggestBlabs'])->middleware(['auth', 'verified'])->name('blabs.suggest');

require __DIR__.'/auth.php';
