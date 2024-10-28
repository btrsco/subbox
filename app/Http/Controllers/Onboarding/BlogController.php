<?php

namespace App\Http\Controllers\Onboarding;

use App\Enums\MetricKey;
use App\Http\Controllers\Controller;
use App\Http\Requests\Onboarding\BlogStoreRequest;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->incrementMetric(MetricKey::ONBOARDING_STARTED);

        if ($user->blog->exists()) {
            return redirect()->route('onboarding.subscribers');
        }

        return Inertia::render('Onboarding/Blog', [
            'status' => session('status'),
        ]);
    }

    public function store(BlogStoreRequest $request)
    {
        $request->user()->blog()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $request->validated()
        );

        return redirect()->route('onboarding.subscribers');
    }
}
