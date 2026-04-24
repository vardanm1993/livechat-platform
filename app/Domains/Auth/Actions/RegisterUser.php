<?php

namespace App\Domains\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class RegisterUser
{
    /**
     * @param  array{name: string, email: string, password: string}  $data
     */
    public function handle(array $data): User
    {
        return User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
