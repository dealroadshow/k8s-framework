<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\Framework\Core\AbstractManifest;

abstract class AbstractPrometheusRule extends AbstractManifest implements PrometheusRuleInterface
{
    public function apiVersion(): string
    {
        return 'monitoring.coreos.com/v1';
    }

    public static function kind(): string
    {
        return 'PrometheusRule';
    }
}
