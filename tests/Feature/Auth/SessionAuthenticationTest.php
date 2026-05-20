<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('authenticates a user with valid credentials', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'vardan@example.com',
            'password' => 'password',
        ])
        ->assertRedirect('/');

    $this->assertAuthenticatedAs($user);
});

it('normalizes the login email before authentication', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'VARDAN@EXAMPLE.COM',
            'password' => 'password',
        ])
        ->assertRedirect('/');

    $this->assertAuthenticatedAs($user);
});

it('does not authenticate a user with an invalid password', function (): void {
    /** @var TestCase $this */
    User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'vardan@example.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('requires an email address', function (): void {
    /** @var TestCase $this */
    $this->from(route('login'))
        ->post(route('login'), [
            'email' => '',
            'password' => 'password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('requires a password', function (): void {
    /** @var TestCase $this */
    $this->from(route('login'))
        ->post(route('login'), [
            'email' => 'vardan@example.com',
            'password' => '',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('password');

    $this->assertGuest();
});

it('logs out an authenticated user', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});
