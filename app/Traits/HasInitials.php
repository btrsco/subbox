<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasInitials
{
    public function initials(): Attribute
    {
        return Attribute::get(function() {
            $words = explode(' ', $this->name);
            $initials = '';

            foreach ($words as $word) {
                $initials .= $word[0];
            }

            return $initials;
        });
    }
}
