<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priority extends Model
{
    use HasFactory;

    public const LOW = 'low';
    public const MEDIUM = 'medium';
    public const HIGH = 'high';
    
    public const LEVELS = [
        self::LOW => 'low',
        self::MEDIUM => 'medium',
        self::HIGH => 'high',
    ];
    
    /** @var array */
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }
}
