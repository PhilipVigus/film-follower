<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Trailer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function scopeWithoutIgnoredTags($query, User $user)
    {
        $query->whereDoesntHave('tags', function ($query) use ($user) {
            $query->whereIn(
                'id',
                $user->ignoredTrailerTags->pluck('id')
            );
        })->orDoesntHave('tags');
    }

    public function scopeWithoutIgnoredPhrases($query, User $user)
    {
        $ignoredPhrases = $user->ignoredTrailerTitlePhrases->pluck('phrase');

        $query->where(function ($query) use ($ignoredPhrases) {
            foreach ($ignoredPhrases as $phrase) {
                $query->where('type', 'not like', '%' . $phrase . '%');
            }
        });
    }
}
