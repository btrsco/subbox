<?php

namespace App\Models;

use App\Traits\HasInitials;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    /** @use HasFactory<\Database\Factories\BlogFactory> */
    use HasFactory,
        HasInitials;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'user_id',
            'name',
            'slug',
            'bio',
        ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string> $appends
     */
    protected $appends
        = [
            'initials',
            'url',
        ];

    /* Relationships
     * - - - - - - - - - - - - - */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /* Accessors & Mutators
     * - - - - - - - - - - - - - */

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => route('blogs.show', $this),
        );
    }
}
