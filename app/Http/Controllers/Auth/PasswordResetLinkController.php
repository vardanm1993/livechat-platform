<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

final class PasswordResetLinkController extends Controller
{
    public function create(): Response
    {
        return response('Forgot password screen placeholder.');
    }

    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        Password::sendResetLink($request->resetLinkPayload());

        return back()->with('status', 'If the email exists, a password reset link will be sent.');
    }
}
