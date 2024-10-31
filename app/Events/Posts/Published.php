<?php

namespace App\Events\Posts;

use App\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;

class Published
{
    use Dispatchable;

    public function __construct(
        public Post $post
    ) {}
}
