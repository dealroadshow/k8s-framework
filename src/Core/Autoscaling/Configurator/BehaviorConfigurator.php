<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator;

use Dealroadshow\K8S\Data\HorizontalPodAutoscalerBehavior;

readonly class BehaviorConfigurator
{
    public function __construct(private HorizontalPodAutoscalerBehavior $behavior)
    {
    }

    public function scaleUp(): HPAScalingRulesConfigurator
    {
        return new HPAScalingRulesConfigurator($this->behavior->scaleUp());
    }

    public function scaleDown(): HPAScalingRulesConfigurator
    {
        return new HPAScalingRulesConfigurator($this->behavior->scaleDown());
    }
}
