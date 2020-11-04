<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress;

use Dealroadshow\K8S\API\Extensions\Ingress;
use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Framework\Core\AppAwareTrait;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendFactory;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;

abstract class AbstractIngress implements IngressInterface
{
    use AppAwareTrait;

    public function backend(IngressBackendFactory $factory): ?IngressBackend
    {
        return null;
    }

    public function configureMeta(MetadataConfigurator $meta): void
    {
    }

    public function configureIngress(Ingress $ingress): void
    {
    }
}
