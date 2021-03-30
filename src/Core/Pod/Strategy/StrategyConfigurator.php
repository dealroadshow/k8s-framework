<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Strategy;

use Dealroadshow\K8S\Data\DeploymentStrategy;

class StrategyConfigurator
{
    private const TYPE_ROLLING_UPDATE = 'RollingUpdate';

    public function __construct(private DeploymentStrategy $deploymentStrategy)
    {
    }

    public function rollingUpdate(int $maxSurge, int $maxUnavailable): void
    {
        $this->deploymentStrategy
            ->setType(self::TYPE_ROLLING_UPDATE)
            ->rollingUpdate()
                ->setMaxSurge($maxSurge)
                ->setMaxUnavailable($maxUnavailable);
    }
}
