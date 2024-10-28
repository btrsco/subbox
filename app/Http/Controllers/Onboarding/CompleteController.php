<?php

namespace App\Http\Controllers\Onboarding;

use App\Enums\MetricKey;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CompleteController extends Controller
{
    public function index()
    {
        return Inertia::render('Onboarding/Complete', [
            'blog' => auth()->user()->blog,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $user->incrementMetric(MetricKey::ONBOARDING_COMPLETED);

        return redirect()->route('dashboard');
    }
}
