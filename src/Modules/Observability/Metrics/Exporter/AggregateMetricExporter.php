<?php

namespace Ninja\DeviceTracker\Modules\Observability\Metrics\Exporter;

use Ninja\DeviceTracker\Modules\Observability\Contracts\MetricAggregationRepository;
use Ninja\DeviceTracker\Modules\Observability\Enums\MetricType;
use Ninja\DeviceTracker\Modules\Observability\Metrics\Exporter\Metric\Factory;
use Ninja\DeviceTracker\Modules\Observability\Repository\Dto\Metric;

final readonly class AggregateMetricExporter extends AbstractMetricExporter
{
    public function __construct(
        private MetricAggregationRepository $repository
    ) {
        parent::__construct();
    }
    protected function collect(): array
    {
        $result = [];

        foreach (MetricType::cases() as $type) {
            $metrics = $this->repository->findByType($type);
            $exportedMetrics = $metrics->map(function (Metric $metric) {
                return Factory::create($metric)->export();
            })->toArray();

            $result = array_merge($result, $exportedMetrics);
        }

        return $result;
    }
}
