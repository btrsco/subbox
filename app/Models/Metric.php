<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Metric extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'measurable',
            'key',
            'value',
            'year',
            'month',
        ];

    /* Relationships
     * - - - - - - - - - - - - - */

    public function measurable(): MorphTo
    {
        return $this->morphTo();
    }
}
