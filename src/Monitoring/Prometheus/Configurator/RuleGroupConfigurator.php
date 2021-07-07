<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

class RuleGroupConfigurator
{
    public function __construct(private \ArrayObject $data)
    {
        $this->data['rules'] = new \ArrayObject();
    }

    public function partialResponseStrategy(string $strategy): static
    {
        $this->data['partial_response_strategy'] = $strategy;

        return $this;
    }

    public function interval(string $interval): static
    {
        $this->data['interval'] = $interval;

        return $this;
    }

    public function rules(): GroupRulesConfigurator
    {
        return new GroupRulesConfigurator($this->data['rules']);
    }
}
