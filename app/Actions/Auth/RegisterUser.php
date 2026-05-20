<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;

final class RegisterUser
{
    /**
     * @param  array{name: string, email: string, password: string}  $data
     */
    public function handle(array $data): User
    {
        return User::query()->create($data);
    }
}
