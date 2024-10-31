<?php

namespace App\Traits;

use App\Enums\MetricKey;
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
     * Check if a metric exists for given key, year and month.
     *
     * @param  MetricKey  $key
     * @param  int|null  $year
     * @param  int|null  $month
     *
     * @return bool
     */
    public function hasMetric(MetricKey $key, ?int $year = null, ?int $month = null): bool
    {
        return $this->metrics()->where([
            'key'   => $key,
            'year'  => $year ?? now()->year,
            'month' => $month ?? now()->month,
        ])->exists();
    }

    /**
     * Check if a metric exists for given key.
     *
     * @param  MetricKey  $key
     *
     * @return bool
     */
    public function metricExists(MetricKey $key): bool
    {
        return $this->metrics()->where('key', $key)->exists();
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
    public function incrementMetric(MetricKey $key, int $value = 1, ?int $year = null, ?int $month = null): void
    {
        $this->metrics()->firstOrCreate([
            'key'   => $key->value,
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
    public function decrementMetric(MetricKey $key, int $value = 1, ?int $year = null, ?int $month = null): void
    {
        $this->metrics()->where([
            'key'   => $key->value,
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
    public function resetMetric(MetricKey $key, ?int $year = null, ?int $month = null): void
    {
        $this->metrics()->where([
            'key'   => $key->value,
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
