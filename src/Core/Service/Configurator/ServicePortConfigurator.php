<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Service\Configurator;

use Dealroadshow\K8S\Data\ServicePort;
use Dealroadshow\K8S\Framework\Core\Service\IPProtocol;

class ServicePortConfigurator
{
    private ServicePort $port;

    public function __construct(ServicePort $port)
    {
        $this->port = $port;
    }

    public function setProtocol(IPProtocol $protocol): self
    {
        $this->port->setProtocol($protocol->toString());

        return $this;
    }

    public function setName(string $name): self
    {
        $this->port->setName($name);

        return $this;
    }

    public function setNodePort(int $nodePort): self
    {
        $this->port->setNodePort($nodePort);

        return $this;
    }
}
