<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress;

use Dealroadshow\K8S\API\Networking\Ingress;
use Dealroadshow\K8S\Framework\Core\AbstractManifest;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendConfigurator;

abstract class AbstractIngress extends AbstractManifest implements IngressInterface
{
    public function defaultBackend(IngressBackendConfigurator $factory): void
    {
    }

    public function ingressClassName(): string|null
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
