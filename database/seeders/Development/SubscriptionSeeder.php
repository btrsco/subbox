<?php

namespace Database\Seeders\Development;

use App\Models\Blog;
use App\Models\EmailSubscriber;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users            = \App\Models\User::all();
        $emailSubscribers = \App\Models\EmailSubscriber::all();

        $users->each(function (\App\Models\User $user) {
            $this->createSubscription($user, Blog::inRandomOrder()->first());
        });

        $emailSubscribers->each(function (\App\Models\EmailSubscriber $emailSubscriber) {
            $this->createSubscription($emailSubscriber, Blog::inRandomOrder()->first());
        });
    }

    private function createSubscription(User|EmailSubscriber $subscriber, Blog $blog): void
    {
        while ($subscriber->subscriptions()->where('blog_id', $blog->id)->exists()) {
            $blog = Blog::inRandomOrder()->first();
        }

        \App\Models\Subscription::factory()->create([
            'subscriber_id'   => $subscriber->id,
            'subscriber_type' => get_class($subscriber),
            'blog_id'         => $blog->id,
        ]);
    }
}
