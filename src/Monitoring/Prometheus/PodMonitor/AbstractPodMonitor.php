<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\PodMonitor;

use Dealroadshow\K8S\Framework\Monitoring\Prometheus\AbstractMonitor;

abstract class AbstractPodMonitor extends AbstractMonitor implements PodMonitorInterface
{
    public static function kind(): string
    {
        return 'PodMonitor';
    }
}
