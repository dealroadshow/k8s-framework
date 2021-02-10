<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Framework\App\AppInterface;

class IngressBackendFactory
{
    public function __construct(private AppInterface $app)
    {
    }

    public function fromServiceNameAndPort(string $serviceName, int|string $servicePort): IngressBackend
    {
        $backend = new IngressBackend($serviceName, $servicePort);
        $backend
            ->setServiceName($serviceName)
            ->setServicePort($servicePort);

        return $backend;
    }

    public function fromServiceClassAndPort(string $serviceClass, int|string $servicePort): IngressBackend
    {
        $serviceName = $this->app->namesHelper()->byServiceClass($serviceClass);

        return $this->fromServiceNameAndPort($serviceName, $servicePort);
    }
}
