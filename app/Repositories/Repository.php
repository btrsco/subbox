<?php

namespace App\Repositories;

use App\Traits\CanTransactWithDatabase;

readonly class Repository
{
    use CanTransactWithDatabase;
}
