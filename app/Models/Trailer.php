<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trailer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
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
