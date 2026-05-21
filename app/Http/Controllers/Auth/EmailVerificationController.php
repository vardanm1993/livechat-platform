<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class EmailVerificationController extends Controller
{
    public function notice(): Response
    {
        return response('Email verification notice placeholder.');
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

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
