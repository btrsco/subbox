<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailSubscriber>
 */
class EmailSubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function faked(): static
    {
        return $this->state(fn(array $attributes) => [
            'email' => fake()->unique()->safeEmail(),
            'name'  => fake()->boolean(25) ? fake()->name() : null,
        ]);
    }
}
