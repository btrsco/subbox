<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\MetricKey;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $blog = $user->blog;

        return Inertia::render('Dashboard/Index', [
            'recentlyVerified' => $request->query('verified') === '1',
            'setupCompleted'   => $user->metricExists(MetricKey::SETUP_COMPLETED),
            'subscriberCount'  => $blog->subscriptions()->count(),
            'draftPosts'       => $blog->posts()->drafts()->latest('updated_at')->paginate(3),
            'recentPosts'      => $blog->posts()->published()->latest('published_at')->paginate(5),
            'postCount'        => $blog->posts()->count(),
        ]);
    }

    public function hideWelcome(Request $request)
    {
        $user = $request->user();
        $user->incrementMetric(MetricKey::SETUP_COMPLETED);

        return redirect()->route('dashboard.index');
    }
}
