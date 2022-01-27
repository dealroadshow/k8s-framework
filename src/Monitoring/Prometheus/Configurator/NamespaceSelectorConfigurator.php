<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

class NamespaceSelectorConfigurator
{
    public function __construct(private \ArrayObject $data)
    {
    }

    public function any(bool $any): static
    {
        $this->data['any'] = $any;

        return $this;
    }

    /**
     * @param string[] $names
     */
    public function matchNames(array $names): void
    {
        $this->data['matchNames'] = $names;
    }
}
