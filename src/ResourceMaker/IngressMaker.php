<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Extensions\Ingress;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendFactory;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressRulesConfigurator;
use Dealroadshow\K8S\Framework\Core\Ingress\IngressInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

class IngressMaker extends AbstractResourceMaker
{
    public function __construct(private ManifestReferenceUtil $manifestReferenceUtil)
    {
    }

    protected function makeResource(ManifestInterface|IngressInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $ingress = new Ingress();
        $app->metadataHelper()->configureMeta($manifest, $ingress);

        $backendFactory = new IngressBackendFactory($app, $this->manifestReferenceUtil, $ingress->spec()->defaultBackend());
        $manifest->backend($backendFactory);

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
