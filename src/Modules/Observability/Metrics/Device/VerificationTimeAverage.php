<?php

namespace Ninja\DeviceTracker\Modules\Observability\Metrics\Device;

use Ninja\DeviceTracker\Modules\Observability\Enums\MetricName;
use Ninja\DeviceTracker\Modules\Observability\Enums\MetricType;
use Ninja\DeviceTracker\Modules\Observability\Metrics\MetricDefinition;

class VerificationTimeAverage extends MetricDefinition
{
    public static function create(): self
    {
        return new self(
            name: MetricName::DeviceVerificationTime,
            type: MetricType::Average,
            description: 'Average time taken for device verification',
            unit: 'seconds',
            required_dimensions: ['platform_family'],
            allowed_dimensions: [
                'browser_family',
                'device_type',
                'status',
            ],
            min: 0,
            max: 86400 * 7, // 7 días
        );
    }
}