<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Ports;

use Dealroadshow\K8S\Data\Collection\ContainerPortList;
use Dealroadshow\K8S\Data\ContainerPort;

class PortsConfigurator
{
    private ContainerPortList $ports;

    public function __construct(ContainerPortList $ports)
    {
        $this->ports = $ports;
    }

    public function add(int $containerPort): ContainerPortBuilder
    {
        $port = new ContainerPort($containerPort);
        $this->ports->add($port);

        return new ContainerPortBuilder($port);
    }
}
