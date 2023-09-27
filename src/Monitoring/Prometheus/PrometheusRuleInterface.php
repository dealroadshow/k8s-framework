<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\RuleGroupsConfigurator;

interface PrometheusRuleInterface extends ManifestInterface
{
    public function groups(RuleGroupsConfigurator $groups): void;
}
