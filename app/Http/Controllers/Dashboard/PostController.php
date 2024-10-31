<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Posts\Published;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Blog;
use App\Models\Post;
use App\Rules\PublishedAt;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user         = $request->user();
        $blog         = $user->blog;
        $statusFilter = $request->query('status', 'published');
        $order        = $request->query('order', 'newest');


        $postsQuery = $blog->posts()->getQuery();
        $postsQuery = $this->filterPostsByStatus($postsQuery, $statusFilter);
        $postsQuery = $this->orderPosts($postsQuery, $order);

        $filteredPosts = $postsQuery->paginate(10)->withQueryString();
        $postCounts    = $this->getPostCounts($statusFilter, $filteredPosts, $blog);

        return Inertia::render('Dashboard/Posts/Index', [
            'selectedStatus' => $statusFilter,
            'selectedOrder'  => $order,
            'posts'          => $filteredPosts,
            'postCounts'     => $postCounts,
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'blog_id' => $user->blog->id,
            'title'   => 'Untitled',
            'slug'    => 'untitled',
        ]);

        return redirect()->route('dashboard.posts.edit', $post);
    }

    public function edit(Post $post)
    {
        if ($post->blog->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Dashboard/Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($post->blog->user_id !== auth()->id()) {
            abort(403);
        }

        $publishedAt = $request->published_at === 'now' ? now() : $request->published_at;

        $post->update([
            'title'        => $request->get('title'),
            'subtitle'     => $request->get('subtitle'),
            'content'      => $request->get('content'),
            'published_at' => $publishedAt,
        ]);

        if ($post->published_at) {
            event(new Published($post));
        }

        return redirect()->route('dashboard.posts.edit', $post);
    }

    public function destroy(Post $post)
    {
        if ($post->blog->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->back();
    }

    public function unpublish(Request $request, Post $post)
    {
        if ($post->blog->user_id !== auth()->id()) {
            abort(403);
        }

        $post->update([
            'published_at' => null,
        ]);

        return redirect()->back();
    }

    private function filterPostsByStatus(Builder $query, string $status = 'published'): Builder
    {
        return match ($status) {
            default => $query->published(),
            'draft' => $query->drafts(),
            'scheduled' => $query->scheduled(),
        };
    }

    private function orderPosts(Builder $query, string $order = 'newest'): Builder
    {
        // dd($order);
        return match ($order) {
            default => $query->latest(),
            'oldest' => $query->oldest(),
            'updated' => $query->latest('updated_at'),
            'title' => $query->orderBy('title'),
        };
    }

    private function getPostCounts(string $filter, LengthAwarePaginator $filteredPosts, Blog $blog)
    {
        return [
            'published' => $filter === 'published' ? $filteredPosts->total() : $blog->posts()->published()->count(),
            'drafts'    => $filter === 'draft' ? $filteredPosts->total() : $blog->posts()->drafts()->count(),
            'scheduled' => $filter === 'scheduled' ? $filteredPosts->total() : $blog->posts()->scheduled()->count(),
        ];
    }
}
