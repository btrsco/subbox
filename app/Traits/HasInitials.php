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

            if (count($words) === 1) {
                return $words[0][0] ?? '';
            }

            for ($i = 0; $i < 2; $i++) {
                $initials .= $words[$i][0] ?? '';
            }

            return $initials;
        });
    }
}
