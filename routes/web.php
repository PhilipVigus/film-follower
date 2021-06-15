<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controllers;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/get-trailers', Controllers\GetTrailersController::class)->name('get-trailers');
Route::get('/films', Controllers\ShowFilmsController::class)->name('films');
