<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

final class AuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return response('Login screen placeholder.');
    }

    public function store(): Response
    {
        return response('Login submission placeholder.', Response::HTTP_ACCEPTED);
    }

    public function destroy(): RedirectResponse
    {
        return redirect('/');
    }
}
