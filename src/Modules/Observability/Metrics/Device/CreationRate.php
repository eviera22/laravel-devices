<?php

namespace Ninja\DeviceTracker\Modules\Observability\Metrics\Device;

use Ninja\DeviceTracker\Modules\Observability\Enums\MetricName;
use Ninja\DeviceTracker\Modules\Observability\Enums\MetricType;
use Ninja\DeviceTracker\Modules\Observability\Metrics\MetricDefinition;

class CreationRate extends MetricDefinition
{
    public static function create(): self
    {
        return new self(
            name: MetricName::DeviceCreationRate,
            type: MetricType::Rate,
            description: 'Rate of new device registrations per hour',
            unit: 'devices/hour',
            required_dimensions: ['platform_family'],
            allowed_dimensions: [
                'browser_family',
                'device_type',
            ],
            min: 0,
            max: PHP_INT_MAX,
        );
    }
}