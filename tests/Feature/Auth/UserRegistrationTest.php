<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('registers a user with valid data', function (): void {
    /** @var TestCase $this */
    $response = $this->post(route('register'), [
        'name' => 'Vardan Test',
        'email' => 'vardan@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/');

    $this->assertAuthenticated();

    $user = User::query()
        ->where('email', 'vardan@example.com')
        ->firstOrFail();

    expect($user->name)->toBe('Vardan Test');
    expect(Hash::check('password', $user->password))->toBeTrue();
});

it('stores the email address in lowercase', function (): void {
    /** @var TestCase $this */
    $this->post(route('register'), [
        'name' => 'Vardan Test',
        'email' => 'VARDAN@EXAMPLE.COM',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    expect(User::query()->where('email', 'vardan@example.com')->exists())->toBeTrue();
});

it('requires a name', function (): void {
    /** @var TestCase $this */
    $this->from(route('register'))
        ->post(route('register'), [
            'name' => '',
            'email' => 'vardan@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('name');

    $this->assertGuest();
});

it('requires a valid email', function (): void {
    /** @var TestCase $this */
    $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Vardan Test',
            'email' => 'not-an-email',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('requires a unique email address', function (): void {
    /** @var TestCase $this */
    User::factory()->create([
        'email' => 'vardan@example.com',
    ]);

    $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Vardan Test',
            'email' => 'vardan@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('requires password confirmation', function (): void {
    /** @var TestCase $this */
    $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Vardan Test',
            'email' => 'vardan@example.com',
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ])
        ->assertRedirect(route('register'))
        ->assertSessionHasErrors('password');

    $this->assertGuest();
});

it('does not allow authenticated users to submit registration', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('register'), [
            'name' => 'Another User',
            'email' => 'another@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect('/');

    expect(User::query()->where('email', 'another@example.com')->exists())->toBeFalse();
});
