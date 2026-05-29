<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Security\RecordSecurityEvent;
use App\Enums\SecurityEventType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class AuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'status' => session('status'),
        ]);
    }

    public function store(LoginRequest $request, RecordSecurityEvent $recordSecurityEvent): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if (! $user instanceof User) {
            abort(500);
        }

        $recordSecurityEvent->handle(
            type: SecurityEventType::UserLoggedIn,
            user: $user,
            request: $request,
        );

        $request->session()->regenerate();

        return redirect('/');
    }

    public function destroy(Request $request, RecordSecurityEvent $recordSecurityEvent): RedirectResponse
    {
        $user = $request->user();

        if ($user instanceof User) {
            $recordSecurityEvent->handle(
                type: SecurityEventType::UserLoggedOut,
                user: $user,
                request: $request,
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
