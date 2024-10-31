<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * The current blog ID being used by the factory.
     */
    protected static ?int $blogId;

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
        $subscriberType = fake()->randomElement([
            \App\Models\User::class,
            \App\Models\EmailSubscriber::class,
        ]);

        return $this->state(fn(array $attributes) => [
            'subscriber_id'      => $subscriberType::factory()->create()->id,
            'subscriber_type'    => $subscriberType,
            'blog_id'            => static::$blogId ??= \App\Models\Blog::factory()->create()->id,
            'verification_token' => fake()->unique()->md5(),
            'email_verified_at'  => now(),
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
