<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Service\Configurator;

use Dealroadshow\K8S\Api\Core\V1\ServicePort;
use Dealroadshow\K8S\Api\Core\V1\ServicePortList;

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
