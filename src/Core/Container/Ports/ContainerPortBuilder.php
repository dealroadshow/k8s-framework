<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Ports;

use Dealroadshow\K8S\Api\Core\V1\ContainerPort;

class ContainerPortBuilder
{
    private ContainerPort $port;

    public function __construct(ContainerPort $port)
    {
        $this->port = $port;
    }

    public function setName(string $name): self
    {
        $this->port->setName($name);

        return $this;
    }

    public function setHostIP(string $hostIP): self
    {
        $this->port->setHostIP($hostIP);

        return $this;
    }

    public function setHostPort(int $port): self
    {
        $this->port->setHostPort($port);

        return $this;
    }

    public function setProtocol(string $protocol): self
    {
        $this->port->setProtocol($protocol);

        return $this;
    }
}
