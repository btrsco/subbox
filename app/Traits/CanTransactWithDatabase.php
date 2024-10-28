<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait CanTransactWithDatabase
{
    public function transact(callable $callback): bool
    {
        DB::beginTransaction();

        try {
            $result = $callback($this);
            DB::commit();

            return $result ?? true;
        } catch (\Exception $exception) {
            Log::error($exception);
            DB::rollBack();

            return false;
        }
    }
}
