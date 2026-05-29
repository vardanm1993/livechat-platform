<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Actions\Security\RecordSecurityEvent;
use App\Enums\SecurityEventType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(
        RegisterUserRequest $request,
        RegisterUser $registerUser,
        RecordSecurityEvent $recordSecurityEvent,
    ): RedirectResponse {
        $user = $registerUser->handle($request->validated());

        event(new Registered($user));

        $recordSecurityEvent->handle(
            type: SecurityEventType::UserRegistered,
            user: $user,
            request: $request,
        );

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/');
    }
}
