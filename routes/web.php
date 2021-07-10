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
Route::get('/to-shortlist', Controllers\ShowFilmsToShortlistController::class)->name('to-shortlist')->middleware('auth');
Route::get('/shortlist', Controllers\ShowFilmsShortlistController::class)->name('shortlist')->middleware('auth');
Route::get('/watched', Controllers\ShowFilmsWatchedController::class)->name('watched')->middleware('auth');
Route::get('/ignored', Controllers\ShowFilmsIgnoredController::class)->name('ignored')->middleware('auth');
