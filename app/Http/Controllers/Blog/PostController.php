<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show(Blog $blog, Post $post)
    {
        $user         = auth()->user();
        $notBlogOwner = ! $user || ($user->id !== $blog->user_id);

        if ($notBlogOwner && ! $blog->is_verified) {
            abort(404);
        }

        return Inertia::render('Blog/Posts/Show', [
            'emailVerified' => $blog->is_verified,
            'blog'          => $blog,
            'post'          => $post,
            'user'          => $blog->user,
            'status'        => session('status'),
        ]);
    }
}
