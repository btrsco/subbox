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
            ->line("Before we send you emails, we need to confirm your subscription to " .
                "<a href='{$blog->url}'>{$blog->name}</a>. Please click the button below.")
            ->action('Confirm subscription', route('subscriptions.verify', $this->subscription));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
