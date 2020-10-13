<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\ValueObject\IntOrString;

class IngressBackendFactory
{
    private AppInterface $app;

    public function __construct(AppInterface $app)
    {
        $this->app = $app;
    }

    /**
     * @param string     $serviceName
     * @param int|string $servicePort
     *
     * @return IngressBackend
     */
    public function fromServiceNameAndPort(string $serviceName, $servicePort): IngressBackend
    {
        $servicePort = $this->getPort($servicePort);
        $backend = new IngressBackend($serviceName, $servicePort);
        $backend
            ->setServiceName($serviceName)
            ->setServicePort($servicePort);

        return $backend;
    }

    /**
     * @param string     $serviceClass
     * @param int|string $servicePort
     *
     * @return IngressBackend
     */
    public function fromServiceClassAndPort(string $serviceClass, $servicePort): IngressBackend
    {
        $serviceName = $this->app->namesHelper()->byServiceClass($serviceClass);

        return $this->fromServiceNameAndPort($serviceName, $servicePort);
    }

    private function getPort($servicePort): IntOrString
    {
        // TODO change this to int|string typehint when PHP 8.0 is released
        if (is_int($servicePort)) {
            $servicePort = IntOrString::fromInt($servicePort);
        } elseif (is_string($servicePort)) {
            $servicePort = IntOrString::fromString($servicePort);
        } else {
            throw new \TypeError('$servicePort must be an int or a string');
        }

        return $servicePort;
    }
}
