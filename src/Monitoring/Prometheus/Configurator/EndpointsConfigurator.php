<?php

namespace Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator;

use Dealroadshow\K8S\Framework\Monitoring\Prometheus\Configurator\EndpointConfigurator;

class EndpointsConfigurator
{
    public function __construct(private \ArrayObject $data)
    {
    }

    public function add(): EndpointConfigurator
    {
        $endpointData = new \ArrayObject();
        $this->data[] = $endpointData;

        return new EndpointConfigurator($endpointData);
    }
}