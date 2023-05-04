<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\Data\DeploymentStrategy;

class StrategyConfigurator
{
    private const TYPE_ROLLING_UPDATE = 'RollingUpdate';
    private const TYPE_RECREATE = 'Recreate';

    public function __construct(private DeploymentStrategy $deploymentStrategy)
    {
    }

    public function rollingUpdate(int|string $maxSurge, int|string $maxUnavailable): void
    {
        $this->deploymentStrategy
            ->setType(self::TYPE_ROLLING_UPDATE)
            ->rollingUpdate()
                ->setMaxSurge($maxSurge)
                ->setMaxUnavailable($maxUnavailable);
    }

    public function recreate(): void
    {
        $this->deploymentStrategy->setType(self::TYPE_RECREATE);
    }
}
