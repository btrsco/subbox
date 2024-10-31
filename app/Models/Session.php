<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class Session extends Model
{
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'user_id',
            'ip_address',
            'user_agent',
            'payload',
            'last_activity'
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden
        = [
            'payload'
        ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends
        = [
            'browser',
            'device',
            'device_type'
        ];

    /* Accessors & Mutators
     * - - - - - - - - - - - - - */

    public function lastActivity(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->toDateTimeString()
        );
    }

    public function browser(): Attribute
    {
        $agent = new Agent(null, $this->user_agent);

        return Attribute::make(
            get: fn() => $agent->browser()
        );
    }

    public function device(): Attribute
    {
        $agent = new Agent(null, $this->user_agent);

        return Attribute::make(
            get: fn() => $agent->device()
        );
    }

    public function deviceType(): Attribute
    {
        $agent = new Agent(null, $this->user_agent);

        return Attribute::make(
            get: fn() => $agent->deviceType()
        );
    }
}
