<?php

declare(strict_types=1);

namespace App\Actions\Security;

use App\Enums\SecurityEventType;
use App\Models\SecurityEvent;
use App\Models\User;
use Illuminate\Http\Request;

final class RecordSecurityEvent
{
    /**
     * @param  array<string, mixed>  $metadata
     */
    public function handle(
        SecurityEventType $type,
        ?User $user = null,
        ?Request $request = null,
        array $metadata = [],
    ): SecurityEvent {
        return SecurityEvent::query()->create([
            'user_id' => $user?->getKey(),
            'type' => $type,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'metadata' => $metadata,
            'occurred_at' => now(),
        ]);
    }
}
