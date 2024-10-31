<?php

namespace Ninja\DeviceTracker\Modules\Security;

use Ninja\DeviceTracker\Modules\Security\DTO\Risk;
use Ninja\DeviceTracker\Modules\Security\Rule\Collection\SecurityRuleCollection;

final readonly class ThreatCalculator
{
    protected SecurityRuleCollection $rules;

    public function __construct()
    {
        $this->rules = SecurityRuleCollection::from(config('security.rules'));
    }

    public function score(array $context): Risk
    {
        return $this->rules->evaluate($context);
    }
}