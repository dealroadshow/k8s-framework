<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\PodMonitor;

use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\EndpointsConfigurator;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\MonitorInterface;

interface PodMonitorInterface extends MonitorInterface
{
    public function podMetricsEndpoints(EndpointsConfigurator $endpoints): void;
}
