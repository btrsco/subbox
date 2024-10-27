<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SecurityController extends Controller
{
    public function edit(Request $request): Response
    {
        $user = $request->user();

        $twoFactorEnabled  = ! is_null($user->two_factor_secret);
        $twoFactorVerified = $user->hasEnabledTwoFactorAuthentication();

        return Inertia::render('Settings/Security/Edit', [
            'twoFactorEnabled'  => $twoFactorEnabled,
            'twoFactorVerified' => $twoFactorVerified,
            'twoFactorSvg'      => $twoFactorEnabled ? $user->twoFactorQrCodeSvg() : null,
            'status'            => session('status'),
        ]);
    }
}
