<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    use HasFactory;

    const TO_SHORTLIST = 'to_shortlist';
    const SHORTLISTED = 'shortlisted';
    const WATCHED = 'watched';
    const IGNORED = 'ignored';

    const STATUSES = [
        self::TO_SHORTLIST,
        self::SHORTLISTED,
        self::WATCHED,
        self::IGNORED,
    ];

    protected $guarded = [];

    public function trailers(): HasMany
    {
        return $this->hasMany(Trailer::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers_films');
    }

    public function priorities(): HasMany
    {
        return $this->hasMany(Priority::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
