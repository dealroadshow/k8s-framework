<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Data\IngressServiceBackend;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Util\ManifestReferencesService;

class IngressBackendConfigurator
{
    private IngressBackend $backend;

    public function __construct(
        private AppInterface $app,
        private ManifestReferencesService $referencesService,
        IngressBackend $backend
    ) {
        $this->backend = $backend;
    }

    public function fromServiceNameAndPort(string $serviceName, int|string $servicePort): void
    {
        $serviceBackend = new IngressServiceBackend($serviceName);

        if (is_numeric($servicePort)) {
            $serviceBackend->port()->setNumber($servicePort);
        } else {
            $serviceBackend->port()->setName($servicePort);
        }

        $this->backend->setService($serviceBackend);
    }

    public function fromServiceClassAndPort(string $serviceClass, int|string $servicePort): void
    {
        $serviceName = $this->app->namesHelper()->byServiceClass($serviceClass);

        $this->fromServiceNameAndPort($serviceName, $servicePort);
    }

    public function fromManifestReference(ManifestReference $manifestReference): void
    {
        $resource = $this->referencesService->toTypedLocalObjectReference($manifestReference);
        $this->backend->setResource($resource);
    }
}
