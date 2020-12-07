<?php

namespace Dealroadshow\K8S\Framework\Core\Service\Configurator;

use Dealroadshow\K8S\Data\Collection\ServicePortList;
use Dealroadshow\K8S\Data\ServicePort;

class ServicePortsConfigurator
{
    private ServicePortList $ports;

    public function __construct(ServicePortList $ports)
    {
        $this->ports = $ports;
    }

    public function add(int $servicePort, int|string $targetPort): ServicePortConfigurator
    {
        $port = new ServicePort($servicePort);
        $port->setTargetPort($targetPort);
        $this->ports->add($port);

        return new ServicePortConfigurator($port);
    }
}
