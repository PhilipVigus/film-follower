<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Film extends Model
{
    use HasFactory, Sluggable;

    const TO_SHORTLIST = 'to_shortlist';
    const SHORTLISTED = 'shortlisted';
    const REVIEWED = 'reviewed';
    const IGNORED = 'ignored';

    const STATUSES = [
        self::TO_SHORTLIST,
        self::SHORTLISTED,
        self::REVIEWED,
        self::IGNORED,
    ];

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeWithoutIgnoredTags($query, User $user)
    {
        $query->whereDoesntHave('tags', function ($query) use ($user) {
            $query->whereIn(
                'tags.id',
                $user->ignoredTags->pluck('id')
            );
        })->orDoesntHave('tags');
    }
}
