<?php

namespace App\Models;

use App\Http\Livewire\Films;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const TYPE_NORMAL = 'normal';
    const TYPE_GUEST = 'guest';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected static function booted()
    {
        static::created(function (self $user) {
            $user->films()->attach(Film::all());
        });
    }

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'followers_films');
    }

    public function filmsToShortlist(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'followers_films')->wherePivot('status', Film::TO_SHORTLIST);
    }

    public function shortlistedFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'followers_films')->wherePivot('status', Film::SHORTLISTED);
    }

    public function reviewedFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'followers_films')->wherePivot('status', Film::REVIEWED);
    }

    public function ignoredFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'followers_films')->wherePivot('status', Film::IGNORED);
    }

    public function priorities(): HasMany
    {
        return $this->hasMany(Priority::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ignoredTags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'ignored_tags');
    }

    public function ignoredTrailerTitlePhrases(): HasMany
    {
        return $this->hasMany(IgnoredTrailerTitlePhrase::class);
    }

    public function canManageProfile(): bool
    {
        return self::TYPE_GUEST !== $this->type;
    }
}
