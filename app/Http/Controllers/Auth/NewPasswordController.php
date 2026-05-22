<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Security\RecordSecurityEvent;
use App\Enums\SecurityEventType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

final class NewPasswordController extends Controller
{
    public function create(string $token): Response
    {
        return response('Reset password screen placeholder. Token: '.$token);
    }

    public function store(
        ResetPasswordRequest $request,
        RecordSecurityEvent $recordSecurityEvent,
    ): RedirectResponse {
        $status = Password::reset(
            $request->resetPayload(),
            function (User $user, string $password) use ($recordSecurityEvent, $request): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                $recordSecurityEvent->handle(
                    type: SecurityEventType::PasswordResetCompleted,
                    user: $user,
                    request: $request,
                );
            },
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
