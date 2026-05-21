<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return response('Registration screen placeholder.');
    }

    public function store(RegisterUserRequest $request, RegisterUser $registerUser): RedirectResponse
    {
        $user = $registerUser->handle($request->validated());

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/');
    }
}
