<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

final class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_the_forgot_password_screen_to_guests(): void
    {
        $this->withoutVite();

        $this->get(route('password.request'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
                ->component('Auth/ForgotPassword')
            );
    }

    public function test_it_sends_a_password_reset_notification_to_an_existing_user(): void
    {
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
    }

    public function test_it_uses_the_same_public_response_when_the_email_does_not_exist(): void
    {
        Notification::fake();

        $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'missing@example.com',
            ])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('status', 'If the email exists, a password reset link will be sent.');

        Notification::assertNothingSent();
    }

    public function test_it_normalizes_the_password_reset_email_before_sending_the_reset_link(): void
    {
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
    }

    public function test_it_requires_a_valid_email_when_requesting_a_password_reset_link(): void
    {
        $this->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'not-an-email',
            ])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('email');
    }

    public function test_it_shows_the_reset_password_screen_to_guests(): void
    {
        $this->withoutVite();

        $this->get(route('password.reset', ['token' => 'test-token']))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
                ->component('Auth/ResetPassword')
                ->where('token', 'test-token')
            );
    }

    public function test_it_resets_the_password_with_a_valid_token(): void
    {
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

        $this->assertFalse(Hash::check('old-password', $user->password));
        $this->assertTrue(Hash::check('new-password', $user->password));
    }

    public function test_it_normalizes_the_email_before_resetting_the_password(): void
    {
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

        $this->assertTrue(Hash::check('new-password', $user->password));
    }

    public function test_it_does_not_reset_the_password_with_an_invalid_token(): void
    {
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

        $this->assertTrue(Hash::check('old-password', $user->password));
        $this->assertFalse(Hash::check('new-password', $user->password));
    }

    public function test_it_requires_password_confirmation_when_resetting_the_password(): void
    {
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
    }
}
