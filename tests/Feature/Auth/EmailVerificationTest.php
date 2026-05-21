<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('sends an email verification notification after registration', function (): void {
    /** @var TestCase $this */
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
});

it('shows the email verification notice to authenticated users', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->get(route('verification.notice'))
        ->assertOk()
        ->assertSee('Email verification notice placeholder.');
});

it('marks the authenticated user email as verified from a valid signed link', function (): void {
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

    expect($user->fresh()?->hasVerifiedEmail())->toBeTrue();
});

it('does not verify an email from an invalid hash', function (): void {
    /** @var TestCase $this */
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

    expect($user->fresh()?->hasVerifiedEmail())->toBeFalse();
});

it('resends the email verification notification', function (): void {
    /** @var TestCase $this */
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect();

    Notification::assertSentTo($user, VerifyEmail::class);
});

it('protects the email verification notice from guests', function (): void {
    /** @var TestCase $this */
    $this->get(route('verification.notice'))
        ->assertRedirect(route('login'));
});

it('protects the email verification notification resend route from guests', function (): void {
    /** @var TestCase $this */
    $this->post(route('verification.send'))
        ->assertRedirect(route('login'));
});
