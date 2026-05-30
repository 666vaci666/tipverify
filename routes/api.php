<?php

use App\Http\Controllers\Api\TipController;
use App\Http\Controllers\Api\TipsterController;
use Illuminate\Support\Facades\Route;

Route::get('/tips', [TipController::class, 'index']);
Route::get('/tipsters/{user}/stats', [TipsterController::class, 'stats']);