<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriptionFactory> */
    use HasFactory,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'subscriber_id',
            'subscriber_type',
            'blog_id',
            'verification_token',
            'email_verified_at',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
        = [
            'verification_token',
        ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /* Relationships
     * - - - - - - - - - - - - - */

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function subscriber(): MorphTo
    {
        return $this->morphTo();
    }

    /* Scopes
     * - - - - - - - - - - - - - */

    public function scopeVerified($query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }
}
