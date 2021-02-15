<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\Data\Collection\StringList;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\NamespaceSelectorConfigurator;

abstract class AbstractMonitor extends AbstractManifest implements MonitorInterface
{
    public function apiVersion(): string
    {
        return 'monitoring.coreos.com/v1';
    }

    public function jobLabel(): string|null
    {
        return null;
    }

    public function namespaceSelector(NamespaceSelectorConfigurator $namespaceSelector): void
    {
    }

    public function podTargetLabels(StringList $labels): void
    {
    }

    public function sampleLimit(): int|null
    {
        return null;
    }
}
