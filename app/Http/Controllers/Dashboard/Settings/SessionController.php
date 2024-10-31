<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function edit(Request $request)
    {
        return Inertia::render('Dashboard/Settings/Sessions/Edit', [
            'sessions'       => $request->user()->sessions,
            'currentSession' => $request->session()->getId(),
            'status'         => session('status'),
        ]);
    }

    public function destroy(Request $request, Session $session): RedirectResponse
    {
        abort_if($session->user_id !== $request->user()->id, 403);

        $session->delete();

        return Redirect::route('dashboard.settings.sessions.edit');
    }

    public function purge(Request $request): RedirectResponse
    {
        $request->user()
            ->sessions()
            ->delete();

        return Redirect::route('login');
    }
}
