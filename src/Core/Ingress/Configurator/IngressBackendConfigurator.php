<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Data\IngressServiceBackend;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ManifestReferencesService;

readonly class IngressBackendConfigurator
{
    public function __construct(
        private AppInterface $app,
        private AppRegistry $appRegistry,
        private ManifestReferencesService $referencesService,
        private IngressBackend $backend
    ) {
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

    public function withExternalApp(string $appAlias): self
    {
        return new self($this->appRegistry->get($appAlias), $this->appRegistry, $this->referencesService, $this->backend);
    }
}
