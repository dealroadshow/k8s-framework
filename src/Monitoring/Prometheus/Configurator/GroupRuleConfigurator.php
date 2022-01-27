<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

use Dealroadshow\K8S\Data\Collection\StringMap;

class GroupRuleConfigurator
{
    public function __construct(private \ArrayObject $data)
    {
    }

    public function alert(string $alert): static
    {
        $this->data['alert'] = $alert;

        return $this;
    }

    public function annotations(): StringMap
    {
        $this->data['annotations'] = new StringMap();

        return $this->data['annotations'];
    }

    public function for(string $for): static
    {
        $this->data['for'] = $for;

        return $this;
    }

    public function labels(): StringMap
    {
        $this->data['labels'] = new StringMap();

        return $this->data['labels'];
    }

    public function record(string $record): static
    {
        $this->data['record'] = $record;

        return $this;
    }
}
