<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * The current user ID being used by the factory.
     */
    protected static ?int $user_id;

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
        $name = fake()->boolean()
            ? fake()->company()
            : fake()->firstName();
        return $this->state(fn(array $attributes) => [
            'user_id' => static::$user_id ??= \App\Models\User::factory()->faked()->create()->id,
            'name'    => $name,
            'slug'    => str($name)->slug(),
            'bio'     => fake()->paragraph(),
        ]);
    }
}
