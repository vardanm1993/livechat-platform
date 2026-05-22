<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('shows the forgot password screen to guests', function (): void {
    /** @var TestCase $this */
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSee('Forgot password screen placeholder.');
});

it('sends a password reset notification to an existing user', function (): void {
    /** @var TestCase $this */
    Notification::fake();

    $user = User::factory()->create([
        'email' => 'vardan@example.com',
    ]);

    $this->from(route('password.request'))
        ->post(route('password.email'), [
            'email' => 'vardan@example.com',
        ])
        ->assertRedirect(route('password.request'))
        ->assertSessionHas('status', 'If the email exists, a password reset link will be sent.');

    Notification::assertSentTo($user, ResetPassword::class);
});

it('uses the same public response when the email does not exist', function (): void {
    /** @var TestCase $this */
    Notification::fake();

    $this->from(route('password.request'))
        ->post(route('password.email'), [
            'email' => 'missing@example.com',
        ])
        ->assertRedirect(route('password.request'))
        ->assertSessionHas('status', 'If the email exists, a password reset link will be sent.');

    Notification::assertNothingSent();
});

it('normalizes the password reset email before sending the reset link', function (): void {
    /** @var TestCase $this */
    Notification::fake();

    $user = User::factory()->create([
        'email' => 'vardan@example.com',
    ]);

    $this->from(route('password.request'))
        ->post(route('password.email'), [
            'email' => 'VARDAN@EXAMPLE.COM',
        ])
        ->assertRedirect(route('password.request'))
        ->assertSessionHas('status', 'If the email exists, a password reset link will be sent.');

    Notification::assertSentTo($user, ResetPassword::class);
});

it('requires a valid email when requesting a password reset link', function (): void {
    /** @var TestCase $this */
    $this->from(route('password.request'))
        ->post(route('password.email'), [
            'email' => 'not-an-email',
        ])
        ->assertRedirect(route('password.request'))
        ->assertSessionHasErrors('email');
});

it('shows the reset password screen to guests', function (): void {
    /** @var TestCase $this */
    $this->get(route('password.reset', ['token' => 'test-token']))
        ->assertOk()
        ->assertSee('Reset password screen placeholder. Token: test-token');
});

it('resets the password with a valid token', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $this->from(route('password.reset', ['token' => $token]))
        ->post(route('password.update'), [
            'token' => $token,
            'email' => 'vardan@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHas('status');

    $user->refresh();

    expect(Hash::check('old-password', $user->password))->toBeFalse();
    expect(Hash::check('new-password', $user->password))->toBeTrue();
});

it('normalizes the email before resetting the password', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('old-password'),
    ]);

    $token = Password::broker()->createToken($user);

    $this->from(route('password.reset', ['token' => $token]))
        ->post(route('password.update'), [
            'token' => $token,
            'email' => 'VARDAN@EXAMPLE.COM',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect(route('login'))
        ->assertSessionHas('status');

    $user->refresh();

    expect(Hash::check('new-password', $user->password))->toBeTrue();
});

it('does not reset the password with an invalid token', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
        'password' => Hash::make('old-password'),
    ]);

    $this->from(route('password.reset', ['token' => 'invalid-token']))
        ->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => 'vardan@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertRedirect(route('password.reset', ['token' => 'invalid-token']))
        ->assertSessionHasErrors('email');

    $user->refresh();

    expect(Hash::check('old-password', $user->password))->toBeTrue();
    expect(Hash::check('new-password', $user->password))->toBeFalse();
});

it('requires password confirmation when resetting the password', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create([
        'email' => 'vardan@example.com',
    ]);

    $token = Password::broker()->createToken($user);

    $this->from(route('password.reset', ['token' => $token]))
        ->post(route('password.update'), [
            'token' => $token,
            'email' => 'vardan@example.com',
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ])
        ->assertRedirect(route('password.reset', ['token' => $token]))
        ->assertSessionHasErrors('password');
});
