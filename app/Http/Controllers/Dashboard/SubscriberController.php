<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $blog = $user->blog;

        return Inertia::render('Dashboard/Subscribers/Index', [
            'subscriptions' => $blog->subscriptions()->with('subscriber')->paginate(10),
        ]);
    }

    public function destroy(Request $request, Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('dashboard.subscribers.index');
    }
}
