<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\StatefulSet\UpdateStrategy;

use Dealroadshow\K8S\Api\Apps\V1\StatefulSetUpdateStrategy;

class UpdateStrategyConfigurator
{
    private const TYPE_ON_DELETE = 'OnDelete';
    private const TYPE_ROLLING_UPDATE = 'RollingUpdate';

    public function __construct(private StatefulSetUpdateStrategy $strategy)
    {
    }

    public function onDelete(): void
    {
        $this->strategy->setType(self::TYPE_ON_DELETE);
    }

    public function rollingUpdate(): RollingUpdateStrategyConfigurator
    {
        $this->strategy->setType(self::TYPE_ROLLING_UPDATE);

        return new RollingUpdateStrategyConfigurator($this->strategy->rollingUpdate());
    }
}
