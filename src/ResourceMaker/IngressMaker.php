<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Networking\V1\Ingress;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressBackendConfigurator;
use Dealroadshow\K8S\Framework\Core\Ingress\Configurator\IngressRulesConfigurator;
use Dealroadshow\K8S\Framework\Core\Ingress\IngressInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Event\IngressGeneratedEvent;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ManifestReferencesService;

class IngressMaker extends AbstractResourceMaker
{
    public function __construct(
        private readonly ManifestReferencesService $referencesService,
        private readonly AppRegistry $appRegistry
    ) {
    }

    protected function makeResource(ManifestInterface|IngressInterface $manifest, AppInterface $app): APIResourceInterface
    {
        $ingress = new Ingress();
        $app->metadataHelper()->configureMeta($manifest, $ingress);

        $backendConfigurator = new IngressBackendConfigurator(
            app: $app,
            appRegistry: $this->appRegistry,
            referencesService: $this->referencesService,
            backend: $ingress->spec()->defaultBackend()
        );
        $manifest->defaultBackend($backendConfigurator);

        $rules = new IngressRulesConfigurator(
            rules: $ingress->spec()->rules(),
            app: $app,
            referencesService: $this->referencesService,
            appRegistry: $this->appRegistry,
        );
        $manifest->rules($rules);

        $ingressClassName = $manifest->ingressClassName();
        if (null !== $ingressClassName) {
            $ingress->spec()->setIngressClassName($ingressClassName);
        }

        $manifest->configureIngress($ingress);

        $this->dispatcher->dispatch(new IngressGeneratedEvent($manifest, $ingress, $app), IngressGeneratedEvent::NAME);

        return $ingress;
    }

    protected function supportsClass(): string
    {
        return IngressInterface::class;
    }
}
