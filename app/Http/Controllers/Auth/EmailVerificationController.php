<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Security\RecordSecurityEvent;
use App\Enums\SecurityEventType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class EmailVerificationController extends Controller
{
    public function notice(): Response
    {
        return Inertia::render('Auth/VerifyEmail', [
            'message' => session('message'),
        ]);
    }

    public function verify(
        EmailVerificationRequest $request,
        RecordSecurityEvent $recordSecurityEvent,
    ): RedirectResponse {
        $request->fulfill();

        $user = $request->user();

        if ($user instanceof User) {
            $recordSecurityEvent->handle(
                type: SecurityEventType::EmailVerified,
                user: $user,
                request: $request,
            );
        }

        return redirect('/');
    }

    public function send(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_if($user === null, 403);

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent.');
    }
}
