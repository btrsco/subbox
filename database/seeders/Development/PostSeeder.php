<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = \App\Models\Blog::all();

        $blogs->each(function (\App\Models\Blog $blog) {
            \App\Models\Post::factory()
                ->count(fake()->numberBetween(1, 10))
                ->faked()
                ->create([
                    'user_id' => $blog->user_id,
                    'blog_id' => $blog->id,
                ]);
        });
    }
}
