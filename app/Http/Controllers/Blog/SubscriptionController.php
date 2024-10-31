<?php

namespace App\Http\Controllers\Blog;

use App\Events\Subscriptions\Subscribed;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogSubscriptionRequest;
use App\Models\Blog;
use App\Models\EmailSubscriber;
use App\Models\Subscription;
use App\Models\User;
use Inertia\Inertia;

class SubscriptionController extends Controller
{
    public function verify(Blog $blog, Subscription $subscription, string $token)
    {
        if ($subscription->verification_token !== $token) {
            abort(404);
        }

        $subscription->update([
            'email_verified_at' => now(),
        ]);

        return Inertia::render('Blog/Subscription/Verify', [
            'blog' => $blog,
        ]);
    }

    public function store(BlogSubscriptionRequest $request, Blog $blog)
    {
        $email      = $request->validated('email');
        $subscriber = User::where('email')->first();

        if ( ! $subscriber) {
            $subscriber = EmailSubscriber::firstOrCreate([
                'email' => $email,
            ]);
        }

        if ($subscription = $subscriber->subscriptions()->where('blog_id', $blog->id)->first()) {
            event(new Subscribed($subscription));
            return redirect()->route('blog.index', ['blog' => $blog])
                ->with('status', 'already_subscribed');
        }

        $subscription = $subscriber->subscriptions()->create([
            'blog_id' => $blog->id,
        ]);

        event(new Subscribed($subscription));

        return redirect()->route('blog.index', ['blog' => $blog])
            ->with('status', 'subscribed');
    }
}
