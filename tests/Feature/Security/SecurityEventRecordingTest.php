<?php

declare(strict_types=1);

use App\Actions\Security\RecordSecurityEvent;
use App\Enums\SecurityEventType;
use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

uses(RefreshDatabase::class);

it('records a user security event with request context and metadata', function (): void {
    $user = User::factory()->create();

    $request = Request::create('/login', 'POST');
    $request->server->set('REMOTE_ADDR', '203.0.113.10');
    $request->headers->set('User-Agent', 'Livechat Test Agent');

    $securityEvent = app(RecordSecurityEvent::class)->handle(
        type: SecurityEventType::UserLoggedIn,
        user: $user,
        request: $request,
        metadata: ['guard' => 'web'],
    );

    expect($securityEvent)->toBeInstanceOf(SecurityEvent::class)
        ->and($securityEvent->user_id)->toBe($user->getKey())
        ->and($securityEvent->type)->toBe(SecurityEventType::UserLoggedIn)
        ->and($securityEvent->ip_address)->toBe('203.0.113.10')
        ->and($securityEvent->user_agent)->toBe('Livechat Test Agent')
        ->and($securityEvent->metadata)->toBe(['guard' => 'web'])
        ->and($securityEvent->occurred_at)->not->toBeNull();

    expect(SecurityEvent::query()
        ->where('user_id', $user->getKey())
        ->where('type', SecurityEventType::UserLoggedIn->value)
        ->where('ip_address', '203.0.113.10')
        ->where('user_agent', 'Livechat Test Agent')
        ->exists())->toBeTrue();
});
