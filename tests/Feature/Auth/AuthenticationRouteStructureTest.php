<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

uses(RefreshDatabase::class);

it('exposes the registration screen to guests', function (): void {
    /** @var TestCase $this */
    $this->get(route('register'))
        ->assertOk()
        ->assertSee('Registration screen placeholder.');
});

it('accepts the registration submission route for guests', function (): void {
    /** @var TestCase $this */
    $this->post(route('register'))
        ->assertStatus(Response::HTTP_ACCEPTED)
        ->assertSee('Registration submission placeholder.');
});

it('exposes the login screen to guests', function (): void {
    /** @var TestCase $this */
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('Login screen placeholder.');
});

it('accepts the login submission route for guests', function (): void {
    /** @var TestCase $this */
    $this->post(route('login'))
        ->assertStatus(Response::HTTP_ACCEPTED)
        ->assertSee('Login submission placeholder.');
});

it('protects the logout route from guests', function (): void {
    /** @var TestCase $this */
    $this->post(route('logout'))
        ->assertRedirect(route('login'));
});

it('allows an authenticated user to reach the logout route', function (): void {
    /** @var TestCase $this */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');
});
