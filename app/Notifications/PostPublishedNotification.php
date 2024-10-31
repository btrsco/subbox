<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Post $post
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $blog = $this->post->blog;
        $excerpt = str($this->post->content)->words(20, '...');

        return (new MailMessage)
            ->subject("New post published on {$blog->name}")
            ->line("A new post has been published on {$blog->name}")
            ->line('# ' . $this->post->title)
            ->line($excerpt)
            ->action('Continue reading', route('blog.posts.show', [
                'blog' => $blog->slug,
                'post' => $this->post->slug,
            ]));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
