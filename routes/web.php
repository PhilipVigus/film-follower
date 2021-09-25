<?php

use App\Http\Livewire\Tag;
use App\Http\Livewire\Tags;
use App\Http\Livewire\Ignored;
use App\Http\Livewire\Reviewed;
use App\Http\Livewire\Shortlist;
use App\Http\Livewire\ToShortlist;
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
    Route::get('/to-shortlist', ToShortlist::class)->name('to-shortlist');
    Route::get('/shortlist', Shortlist::class)->name('shortlist');
    Route::get('/reviewed', Reviewed::class)->name('reviewed');
    Route::get('/ignored', Ignored::class)->name('ignored');
    Route::get('/tags/{tag:slug}', Tag::class)->name('tag');
    Route::get('/tags', Tags::class)->name('tags');
});
