<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipsterController;

Route::get('/', [TipController::class, 'index']);
Route::get('/tipster/{user}', [TipsterController::class, 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/tips/create',      [TipController::class, 'create']);
    Route::post('/tips',            [TipController::class, 'store']);
    Route::get('/tips/{tip}/edit',  [TipController::class, 'edit']);
    Route::patch('/tips/{tip}',     [TipController::class, 'update']);
    Route::delete('/tips/{tip}',    [TipController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';