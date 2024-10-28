<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\EmailSubscriber
 *
 * @method \App\Services\EmailSubscriberService service()
 */
class EmailSubscriber extends Model
{
    /** @use HasFactory<\Database\Factories\EmailSubscriberFactory> */
    use HasFactory,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'email',
        ];

    /* Relationships
     * - - - - - - - - - - - - - */

    public function subscriptions(): MorphMany
    {
        return $this->morphMany(Subscription::class, 'subscriber');
    }
}
