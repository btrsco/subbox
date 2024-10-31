<?php

namespace App\Rules;

use Closure;
use DateTime;
use DateTimeInterface;
use Illuminate\Contracts\Validation\ValidationRule;

class PublishedAt implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }

        if ($value === 'now') {
            return;
        }

        $date = DateTime::createFromFormat(DateTimeInterface::ATOM, $value);

        if ($date === false) {
            $fail("The :attribute must be null, an ISO 8601 date string, or 'now'.");
        }
    }
}
