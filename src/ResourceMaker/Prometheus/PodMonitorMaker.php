<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker\Prometheus;

use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\EndpointsConfigurator;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\MonitorInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\PodMonitor\PodMonitorInterface;

class PodMonitorMaker extends AbstractMonitorMaker
{
    protected function configureMonitor(MonitorInterface|PodMonitorInterface $manifest, \ArrayObject $data): void
    {
        $data['spec']['podMetricsEndpoints'] = new \ArrayObject();

        $endpoints = new EndpointsConfigurator($data['spec']['podMetricsEndpoints']);
        $manifest->podMetricsEndpoints($endpoints);
    }

    protected function supportsClass(): string
    {
        return PodMonitorInterface::class;
    }
}
