<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Autoscaling\Configurator;

use Dealroadshow\K8S\Data\HPAScalingPolicy;
use Dealroadshow\K8S\Data\HPAScalingRules;
use Dealroadshow\K8S\Framework\Core\Autoscaling\SelectPolicy;
use Dealroadshow\K8S\Framework\Core\Autoscaling\StabilizationWindowSeconds;

final readonly class HPAScalingRulesConfigurator
{
    public function __construct(private HPAScalingRules $rules)
    {
    }

    public function addPolicy(int $periodSeconds, string $type, int $value): self
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('$value must be greater than 0');
        }

        $policy = new HPAScalingPolicy(periodSeconds: $periodSeconds, type: $type, value: $value);
        $this->rules->policies()->add($policy);

        return $this;
    }

    public function stabilizationWindowSeconds(StabilizationWindowSeconds $seconds): self
    {
        $this->rules->setStabilizationWindowSeconds($seconds->value);

        return $this;
    }

    public function selectPolicy(SelectPolicy $policy): self
    {
        $this->rules->setSelectPolicy($policy->value);

        return $this;
    }
}
