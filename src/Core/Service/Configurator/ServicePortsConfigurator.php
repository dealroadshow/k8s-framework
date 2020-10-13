<?php

namespace Dealroadshow\K8S\Framework\Core\Service\Configurator;

use Dealroadshow\K8S\Data\Collection\ServicePortList;
use Dealroadshow\K8S\Data\ServicePort;
use Dealroadshow\K8S\ValueObject\IntOrString;

class ServicePortsConfigurator
{
    private ServicePortList $ports;

    public function __construct(ServicePortList $ports)
    {
        $this->ports = $ports;
    }

    /**
     * @param int           $servicePort
     * @param int|string    $targetPort
     *
     * @return ServicePortConfigurator
     */
    public function add(int $servicePort, $targetPort)
    {
        // TODO change this to int|string typehint when PHP 8.0 is released
        if (is_int($targetPort)) {
            $targetPort = IntOrString::fromInt($targetPort);
        } elseif (is_string($targetPort)) {
            $targetPort = IntOrString::fromString($targetPort);
        } else {
            throw new \TypeError('$targetPort must be an int or a string');
        }

        $port = new ServicePort($servicePort);
        $port->setTargetPort($targetPort);
        $this->ports->add($port);

        return new ServicePortConfigurator($port);
    }
}
