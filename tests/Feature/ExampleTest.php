<?php

namespace Tests\Feature;

use Inertia\Testing\AssertableInertia as Assert;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Home')
                ->has('app.name')
                ->where('app.locale', 'en')
                ->has('stats.stack', 6)
                ->has('stats.pillars', 4)
            );
    }
}
