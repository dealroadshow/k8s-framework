<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Deployment;

use Dealroadshow\K8S\Data\DeploymentStrategy;
use Dealroadshow\K8S\Framework\Core\Deployment\ValueObject\NumberOrPercents;

class StrategyConfigurator
{
    private const TYPE_ROLLING_UPDATE = 'RollingUpdate';
    private const TYPE_RECREATE = 'Recreate';

    public function __construct(private DeploymentStrategy $deploymentStrategy)
    {
    }

    public function rollingUpdate(NumberOrPercents $maxSurge, NumberOrPercents $maxUnavailable): void
    {
        $this->deploymentStrategy
            ->setType(self::TYPE_ROLLING_UPDATE)
            ->rollingUpdate()
                ->setMaxSurge($maxSurge->value)
                ->setMaxUnavailable($maxUnavailable->value);
    }

    public function recreate(): void
    {
        $this->deploymentStrategy->setType(self::TYPE_RECREATE);
    }
}
