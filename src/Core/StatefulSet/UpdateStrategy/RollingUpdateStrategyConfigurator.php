<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\StatefulSet\UpdateStrategy;

use Dealroadshow\K8S\Api\Apps\V1\RollingUpdateStatefulSetStrategy;

readonly class RollingUpdateStrategyConfigurator
{
    public function __construct(private RollingUpdateStatefulSetStrategy $rollingUpdate)
    {
    }

    public function setPartition(int $partition): void
    {
        $this->rollingUpdate->setPartition($partition);
    }
}
