<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controllers;

Route::get('/', function () {
    return redirect(route('to-shortlist'));
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/get-trailers', Controllers\GetTrailersController::class)->name('get-trailers');

Route::middleware(['auth'])->group(function () {
    Route::get('/to-shortlist', Controllers\ShowFilmsToShortlistController::class)->name('to-shortlist');
    Route::get('/shortlist', Controllers\ShowFilmsShortlistController::class)->name('shortlist');
    Route::get('/watched', Controllers\ShowFilmsWatchedController::class)->name('watched');
    Route::get('/ignored', Controllers\ShowFilmsIgnoredController::class)->name('ignored');
    Route::get('/tags/{tag:slug}', Controllers\ShowTagController::class)->name('tag');
    Route::get('/tags', Controllers\ShowTagsController::class)->name('tags');
    Route::get('/films/{film:slug}', Controllers\ShowFilmController::class)->name('film');
});
