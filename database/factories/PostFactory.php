<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The current user ID being used by the factory.
     */
    protected static ?int $user_id;

    /**
     * The current blog ID being used by the factory.
     */
    protected static ?int $blog_id;

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
        $title = fake()->sentence();

        return $this->state(fn(array $attributes) => [
            'user_id'      => static::$user_id ??= \App\Models\User::factory()->faked()->create()->id,
            'blog_id'      => static::$blog_id ??= \App\Models\Blog::factory()->faked()->create()->id,
            'title'        => $title,
            'slug'         => str($title)->slug(),
            'subtitle'     => fake()->sentence(),
            'content'      => fake()->paragraphs(3, true),
            'published_at' => fake()->optional()->dateTime(),
        ]);
    }
}
