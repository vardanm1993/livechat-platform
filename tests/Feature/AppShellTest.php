<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class AppShellTest extends TestCase
{
    public function test_it_renders_the_vue_application_shell(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertOk()
            ->assertSee('Livechat Platform')
            ->assertSee('id="app"', false);
    }
}
