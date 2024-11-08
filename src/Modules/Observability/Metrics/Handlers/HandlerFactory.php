<?php

namespace Ninja\DeviceTracker\Modules\Observability\Metrics\Handlers;

use Ninja\DeviceTracker\Modules\Observability\Enums\MetricType;
use Ninja\DeviceTracker\Modules\Observability\Exceptions\MetricHandlerNotFoundException;

final class HandlerFactory
{
    private static ?HandlerCollection $handlers = null;

    private function __construct()
    {
    }

    /**
     * @throws MetricHandlerNotFoundException
     */
    public static function compute(MetricType $type, array $rawValue): float|array
    {
        $handler = self::handlers()->get($type);
        if (!$handler) {
            throw MetricHandlerNotFoundException::forType($type);
        }

        return $handler->compute($rawValue);
    }

    /**
     * @throws MetricHandlerNotFoundException
     */
    public static function merge(MetricType $type, array $windows): float|array
    {
        $handler = self::handlers()->get($type);

        if (!$handler) {
            throw MetricHandlerNotFoundException::forType($type);
        }

        return $handler->merge($windows);
    }

    /**
     * @throws MetricHandlerNotFoundException
     */
    public static function validate(MetricType $type, float $value): bool
    {
        $handler = self::handlers()->get($type);

        if (!$handler) {
            throw MetricHandlerNotFoundException::forType($type);
        }

        return $handler->validate($value);
    }

    private static function initialize(): void
    {
        self::$handlers = new HandlerCollection();

        self::$handlers->add(
            MetricType::Counter,
            new Counter()
        );

        self::$handlers->add(
            MetricType::Gauge,
            new Gauge()
        );

        self::$handlers->add(
            MetricType::Histogram,
            new Histogram(
                config('devices.metrics.buckets', [])
            )
        );

        self::$handlers->add(
            MetricType::Average,
            new Average()
        );

        self::$handlers->add(
            MetricType::Rate,
            new Rate(
                config('devices.metrics.rate_interval', 3600)
            )
        );

        self::$handlers->add(
            MetricType::Summary,
            new Summary(
                config('devices.metrics.quantiles', [0.5, 0.9, 0.95, 0.99])
            )
        );
    }

    public static function handlers(): HandlerCollection
    {
        if (self::$handlers === null) {
            self::initialize();
        }

        return self::$handlers;
    }
}
