<?php

namespace App\Services;

use App\Traits\CanTransactWithDatabase;

readonly class Service
{
    use CanTransactWithDatabase;

    public function __construct(
        private string $modelKey
    ) {}

    public function setRelation(string $relation, mixed $value): void
    {
        $this->{$this->modelKey}->{$relation}()->associate($value);
    }
}
