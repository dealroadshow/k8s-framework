<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Extensions\Ingress;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendFactory;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressRulesConfigurator;
use Dealroadshow\K8S\Framework\Core\Ingress\IngressInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class IngressMaker extends AbstractResourceMaker
{
    protected function makeResource(ManifestInterface|IngressInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $ingress = new Ingress();
        $app->metadataHelper()->configureMeta($manifest, $ingress);

        $backendFactory = new IngressBackendFactory($app);
        $backend = $manifest->backend($backendFactory);
        if (null !== $backend) {
            $ingress->spec()->setBackend($backend);
        }

        $rules = new IngressRulesConfigurator($ingress->spec()->rules());
        $manifest->rules($rules, $backendFactory);

        $manifest->configureIngress($ingress);

        return $ingress;
    }

    protected function supportsClass(): string
    {
        return IngressInterface::class;
    }
}
