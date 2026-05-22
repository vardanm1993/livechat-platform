<?php

declare(strict_types=1);

use App\Enums\SecurityEventType;
use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('records a security event when a user registers', function (): void {
    /** @var TestCase $this */
    $this->post(route('register'), [
        'name' => 'Vardan Test',
        'email' => 'vardan@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect('/');

    $user = User::query()
        ->where('email', 'vardan@example.com')
        ->firstOrFail();

    expect(SecurityEvent::query()
        ->where('user_id', $user->getKey())
        ->where('type', SecurityEventType::UserRegistered->value)
        ->exists())->toBeTrue();
});

it('records a security event when a user logs in', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->post(route('login'), [
        'email' => 'vardan@example.com',
        'password' => 'password',
    ])->assertRedirect('/');

    expect(SecurityEvent::query()
        ->where('user_id', $user->getKey())
        ->where('type', SecurityEventType::UserLoggedIn->value)
        ->exists())->toBeTrue();
});

it('records a security event when a user logs out', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    expect(SecurityEvent::query()
        ->where('user_id', $user->getKey())
        ->where('type', SecurityEventType::UserLoggedOut->value)
        ->exists())->toBeTrue();
});

it('records a security event when a user verifies their email', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ],
    );

    $this->actingAs($user)
        ->get($verificationUrl)
        ->assertRedirect('/');

    expect(SecurityEvent::query()
        ->where('user_id', $user->getKey())
        ->where('type', SecurityEventType::EmailVerified->value)
        ->exists())->toBeTrue();
});

it('records a security event when a user completes password reset', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => 'vardan@example.com',
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ])->assertRedirect(route('login'));

    expect(SecurityEvent::query()
        ->where('user_id', $user->getKey())
        ->where('type', SecurityEventType::PasswordResetCompleted->value)
        ->exists())->toBeTrue();
});
