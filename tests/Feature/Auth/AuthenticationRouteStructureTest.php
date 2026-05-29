<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

final class AuthenticationRouteStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_exposes_the_registration_screen_to_guests(): void
    {
        $this->withoutVite();

        $this->get(route('register'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
                ->component('Auth/Register')
            );
    }

    public function test_it_keeps_the_registration_submission_route_available_for_guests(): void
    {
        $this->from(route('register'))
            ->post(route('register'), [])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_it_exposes_the_login_screen_to_guests(): void
    {
        $this->withoutVite();

        $this->get(route('login'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
                ->component('Auth/Login')
            );
    }

    public function test_it_keeps_the_login_submission_route_available_for_guests(): void
    {
        $this->from(route('login'))
            ->post(route('login'), [])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_it_protects_the_logout_route_from_guests(): void
    {
        $this->post(route('logout'))
            ->assertRedirect(route('login'));
    }

    public function test_it_allows_an_authenticated_user_to_reach_the_logout_route(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect('/');
    }
}
