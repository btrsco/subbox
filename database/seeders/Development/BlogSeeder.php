<?php

namespace Database\Seeders\Development;

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();

        $users->each(function (\App\Models\User $user) {
            \App\Models\Blog::factory()
                ->faked()
                ->create([
                    'user_id' => $user->id,
                ]);
        });
    }
}
