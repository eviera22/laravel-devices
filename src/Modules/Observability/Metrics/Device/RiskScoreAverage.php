<?php

namespace Ninja\DeviceTracker\Modules\Observability\Metrics\Device;

use Ninja\DeviceTracker\Modules\Observability\Enums\MetricName;
use Ninja\DeviceTracker\Modules\Observability\Enums\MetricType;
use Ninja\DeviceTracker\Modules\Observability\Metrics\MetricDefinition;

class RiskScoreAverage extends MetricDefinition
{
    public static function create(): self
    {
        return new self(
            name: MetricName::RiskScoreAverage,
            type: MetricType::Gauge,
            description: 'Average risk score of devices',
            unit: 'score',
            required_dimensions: ['platform_family'],
            allowed_dimensions: [
                'browser_family',
                'device_type',
                'status',
            ],
            min: 0,
            max: 100,
        );
    }
}