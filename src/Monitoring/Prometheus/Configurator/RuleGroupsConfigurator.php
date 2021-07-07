<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

class RuleGroupsConfigurator
{
    public function __construct(private \ArrayObject $data)
    {
    }

    public function add(string $name): RuleGroupConfigurator
    {
        $groupData = new \ArrayObject();
        $groupData['name'] = $name;
        $this->data[] = $groupData;

        return new RuleGroupConfigurator($groupData);
    }
}
