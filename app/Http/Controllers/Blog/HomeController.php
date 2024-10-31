<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Blog $blog)
    {
        $user         = auth()->user();
        $notBlogOwner = ! $user || ($user->id !== $blog->user_id);
        $firstVisit   = ! session()->has('blog_visited:'.$blog->id);

        if ($notBlogOwner && ! $blog->is_verified) {
            abort(404);
        }

        if ($firstVisit) {
            session()->put('blog_visited:'.$blog->id, true);
        }

        return Inertia::render('Blog/Index', [
            'emailVerified' => $blog->is_verified,
            'firstVisit'    => $firstVisit,
            'blog'          => $blog,
            'posts'         => $blog->posts()->published()->latest('published_at')->paginate(10),
            'user'          => $blog->user,
            'status'        => session('status'),
        ]);
    }
}
