<?php

namespace App\Models;

use App\Traits\HasInitials;
use App\Traits\HasMetrics;
use App\Traits\HasService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * App\Models\User
 *
 * @method \App\Services\UserService service()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        HasMetrics,
        HasService,
        HasInitials,
        Notifiable,
        TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'email',
            'password',
            'email_verified_at',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password'          => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string> $appends
     */
    protected $appends
        = [
            'initials',
        ];

    /* Relationships
     * - - - - - - - - - - - - - */

    public function blog(): HasOne
    {
        return $this->hasOne(Blog::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class)
            ->orderBy('last_activity', 'desc');
    }

    public function subscriptions(): MorphMany
    {
        return $this->morphMany(Subscription::class, 'subscriber');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
