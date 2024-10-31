<?php

namespace Ninja\DeviceTracker\Modules\Security\Rule;

use Ninja\DeviceTracker\Models\Session;
use Ninja\DeviceTracker\Modules\Security\DTO\Factor;

final class FingerprintFlippingRule extends AbstractSecurityRule
{
    public function evaluate(array $context): Factor
    {
        $session = $this->session();
        if (!$session) {
            return new Factor($this->factor, 0.0);
        }

        $changes = Session::where('user_id', $session->user_id)
            ->where('created_at', '>=', now()->subHour())
            ->distinct('device_uuid')
            ->count();

        $score = $changes > $this->threshold ? 1.0 : 0.0;
        return new Factor($this->factor, $score);
    }
}