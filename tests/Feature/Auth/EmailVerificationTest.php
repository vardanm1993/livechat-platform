<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

final class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sends_an_email_verification_notification_after_registration(): void
    {
        Notification::fake();

        $this->post(route('register'), [
            'name' => 'Vardan Test',
            'email' => 'vardan@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect('/');

        $user = User::query()
            ->where('email', 'vardan@example.com')
            ->firstOrFail();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_it_shows_the_email_verification_notice_to_authenticated_users(): void
    {
        $this->withoutVite();

        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
                ->component('Auth/VerifyEmail')
            );
    }

    public function test_it_marks_the_authenticated_user_email_as_verified_from_a_valid_signed_link(): void
    {
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

        $this->assertTrue($user->fresh()?->hasVerifiedEmail());
    }

    public function test_it_does_not_verify_an_email_from_an_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1('wrong-email@example.com'),
            ],
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertForbidden();

        $this->assertFalse($user->fresh()?->hasVerifiedEmail());
    }

    public function test_it_resends_the_email_verification_notification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_it_protects_the_email_verification_notice_from_guests(): void
    {
        $this->get(route('verification.notice'))
            ->assertRedirect(route('login'));
    }

    public function test_it_protects_the_email_verification_notification_resend_route_from_guests(): void
    {
        $this->post(route('verification.send'))
            ->assertRedirect(route('login'));
    }
}
