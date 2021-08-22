<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function films(): MorphToMany
    {
        return $this->morphedByMany(Film::class, 'taggable');
    }

    public function newFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class);
    }

    public function trailers(): MorphToMany
    {
        return $this->morphedByMany(Trailer::class, 'taggable');
    }
}
