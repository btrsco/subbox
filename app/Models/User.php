<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\HasMetrics;
use App\Traits\HasRepository;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * App\Models\User
 *
 * @method \App\Repositories\UserRepository repository()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,
        HasMetrics,
        HasRepository,
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
            'role',
            'email_verified_at',
            'last_logged_in_at',
            'last_active_at',
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
            'role'              => UserRole::class,
            'email_verified_at' => 'datetime',
            'last_logged_in_at' => 'datetime',
            'last_active_at'    => 'datetime',
        ];
    }

    /* Relationships
     * - - - - - - - - - - - - - */

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class)
            ->orderBy('last_activity', 'desc');
    }

    /* Scopes
     * - - - - - - - - - - - - - */

    public function scopeOfRole(Builder $query, mixed $role): void
    {
        $role = is_enum($role) ? $role->value : $role;
        $query->where('role', $role);
    }
}
