<?php

namespace App\Traits;

use App\Models\Metric;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMetrics
{
    /**
     * Get the metrics for the model.
     *
     * @return MorphMany
     */
    public function metrics(): MorphMany
    {
        return $this->morphMany(Metric::class, 'measurable');
    }

    /**
     * Increment a metric by a given value.
     *
     * @param  mixed  $key
     * @param  int  $value
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return void
     */
    public function incrementMetric(mixed $key, int $value = 1, ?int $year = null, ?int $month = null): void
    {
        $key = is_enum($key) ? $key->value : $key;

        $this->metrics()->firstOrCreate([
            'key'   => $key,
            'year'  => $year ?? now()->year,
            'month' => $month ?? now()->month,
        ], [
            'value' => 0,
        ])->increment('value', $value);
    }

    /**
     * Decrement a metric by a given value.
     *
     * @param  mixed  $key
     * @param  int  $value
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return void
     */
    public function decrementMetric(mixed $key, int $value = 1, ?int $year = null, ?int $month = null): void
    {
        $key = is_enum($key) ? $key->value : $key;

        $this->metrics()->where([
            'key'   => $key,
            'year'  => $year ?? now()->year,
            'month' => $month ?? now()->month,
        ])->first()?->decrement('value', $value);
    }

    /**
     * Reset a metric back to zero.
     *
     * @param  mixed  $key
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return void
     */
    public function resetMetric(mixed $key, ?int $year = null, ?int $month = null): void
    {
        $key = is_enum($key) ? $key->value : $key;

        $this->metrics()->where([
            'key'   => $key,
            'year'  => $year ?? now()->year,
            'month' => $month ?? now()->month,
        ])->first()?->update(['value' => 0]);
    }

    /**
     * Increment multiple metrics by a given value.
     *
     * @param  array  $keys
     * @param  int  $value
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return void
     */
    public function bulkIncrementMetrics(array $keys, int $value = 1, ?int $year = null, ?int $month = null): void
    {
        foreach ($keys as $key) {
            $this->incrementMetric($key, $value, $year, $month);
        }
    }

    /**
     * Decrement multiple metrics by a given value.
     *
     * @param  array  $keys
     * @param  int  $value
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return void
     */
    public function bulkDecrementMetrics(array $keys, int $value = 1, ?int $year = null, ?int $month = null): void
    {
        $keys = collect($keys)
            ->map(fn($key) => is_enum($key) ? $key->value : $key)
            ->toArray();

        $this->metrics()->whereIn('key', $keys)
            ->where('year', $year ?? now()->year)
            ->where('month', $month ?? now()->month)
            ->decrement('value', $value);
    }

    /**
     * Reset multiple metrics back to zero.
     *
     * @param  array  $keys
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return void
     */
    public function bulkResetMetrics(array $keys, ?int $year = null, ?int $month = null): void
    {
        $keys = collect($keys)
            ->map(fn($key) => is_enum($key) ? $key->value : $key)
            ->toArray();

        $this->metrics()->whereIn('key', $keys)
            ->where('year', $year ?? now()->year)
            ->where('month', $month ?? now()->month)
            ->update(['value' => 0]);
    }
}
