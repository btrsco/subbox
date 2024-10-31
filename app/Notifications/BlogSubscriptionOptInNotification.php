<?php

namespace App\Notifications;

use App\Models\Blog;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogSubscriptionOptInNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Subscription $subscription,
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $blog = Blog::find($this->subscription->blog_id);

        return (new MailMessage)
            ->subject("Confirm your subscription to {$blog->name}")
            ->line("Before we send you emails, we need to confirm your subscription to " .
                "[{$blog->name}]({$blog->url}). Please click the button below.")
            ->action('Confirm subscription', route('blog.subscription.verify', [
                'blog'         => $blog->slug,
                'subscription' => $this->subscription->id,
                'token'        => $this->subscription->verification_token,
            ]));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
