<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress;

use Dealroadshow\K8S\API\Extensions\Ingress;
use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendFactory;

abstract class AbstractIngress extends AbstractManifest implements IngressInterface
{
    public function backend(IngressBackendFactory $factory): ?IngressBackend
    {
        return null;
    }

    public function configureIngress(Ingress $ingress): void
    {
    }

    final public static function kind(): string
    {
        return Ingress::KIND;
    }
}
