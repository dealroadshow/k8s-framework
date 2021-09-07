<?php

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\API\Networking\Ingress;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendConfigurator;
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

        $backendConfigurator = new IngressBackendConfigurator(
            app: $app,
            manifestReferenceUtil: $this->manifestReferenceUtil,
            backend: $ingress->spec()->defaultBackend()
        );
        $manifest->defaultBackend($backendConfigurator);

        $rules = new IngressRulesConfigurator(
            rules: $ingress->spec()->rules(),
            app: $app,
            manifestReferenceUtil: $this->manifestReferenceUtil
        );
        $manifest->rules($rules);

        $ingressClassName = $manifest->ingressClassName();
        if (null !== $ingressClassName) {
            $ingress->spec()->setIngressClassName($ingressClassName);
        }

        $manifest->configureIngress($ingress);

        return $ingress;
    }

    protected function supportsClass(): string
    {
        return IngressInterface::class;
    }
}
