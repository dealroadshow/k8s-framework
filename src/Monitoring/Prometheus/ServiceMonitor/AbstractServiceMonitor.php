<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\ServiceMonitor;

use Dealroadshow\K8S\Data\Collection\StringList;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\AbstractMonitor;

abstract class AbstractServiceMonitor extends AbstractMonitor implements ServiceMonitorInterface
{
    public static function kind(): string
    {
        return 'ServiceMonitor';
    }

    public function targetLabels(StringList $labels): void
    {
    }
}
