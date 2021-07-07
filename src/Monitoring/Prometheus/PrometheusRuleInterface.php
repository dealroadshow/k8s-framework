<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\RuleGroupsConfigurator;

interface PrometheusRuleInterface extends ManifestInterface
{
    public function apiVersion(): string;
    public function groups(RuleGroupsConfigurator $groups): void;
}
