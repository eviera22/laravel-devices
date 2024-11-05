<?php

namespace Ninja\DeviceTracker\Modules\Observability\Metrics\Device;

use Ninja\DeviceTracker\Modules\Observability\Enums\MetricName;
use Ninja\DeviceTracker\Modules\Observability\Enums\MetricType;
use Ninja\DeviceTracker\Modules\Observability\Metrics\MetricDefinition;

class VerifiedDeviceCount extends MetricDefinition
{
    public static function create(): self
    {
        return new self(
            name: MetricName::VerifiedDeviceCount,
            type: MetricType::Gauge,
            description: 'Number of verified devices in the system',
            required_dimensions: [],
            allowed_dimensions: [
                'platform_family',
                'browser_family',
                'device_type',
            ],
            min: 0,
            max: PHP_INT_MAX,
        );
    }
}