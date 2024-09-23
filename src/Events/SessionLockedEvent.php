<?php

namespace Ninja\DeviceTracker\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Ninja\DeviceTracker\Models\Session;

final class SessionLockedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Session $session, public readonly int $code, public readonly Authenticatable $user)
    {
    }
}
