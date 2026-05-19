<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

final class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return response('Registration screen placeholder.');
    }

    public function store(): Response
    {
        return response('Registration submission placeholder.', Response::HTTP_ACCEPTED);
    }
}
