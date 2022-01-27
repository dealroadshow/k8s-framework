<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker\Prometheus;

use Dealroadshow\K8S\Data\Collection\StringList;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\EndpointsConfigurator;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\MonitorInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\ServiceMonitor\ServiceMonitorInterface;

class ServiceMonitorMaker extends AbstractMonitorMaker
{
    protected function supportsClass(): string
    {
        return ServiceMonitorInterface::class;
    }

    protected function configureMonitor(MonitorInterface|ServiceMonitorInterface $manifest, \ArrayObject $data): void
    {
        $targetLabels = new StringList();
        $manifest->targetLabels($targetLabels);

        if ($targetLabels->count() > 0) {
            $data['spec']['targetLabels'] = $targetLabels;
        }

        $data['spec']['endpoints'] = new \ArrayObject();

        $endpoints = new EndpointsConfigurator($data['spec']['endpoints']);
        $manifest->endpoints($endpoints);
    }
}
