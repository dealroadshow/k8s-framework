<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\IngressBackend;
use Dealroadshow\K8S\Data\IngressServiceBackend;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

class IngressBackendFactory
{
    // @TODO refactor this class to IngressBackendConfigurator, since now backends should be configured, not created
    private IngressBackend|null $ingressBackend;

    public function __construct(
        private AppInterface $app,
        private ManifestReferenceUtil $manifestReferenceUtil,
        IngressBackend|null $backend = null
    ) {
        $this->ingressBackend = $backend;
    }

    public function fromServiceNameAndPort(string $serviceName, int|string $servicePort): IngressBackend
    {
        $backend = $this->ingressBackend ?? new IngressBackend();
        $serviceBackend = new IngressServiceBackend($serviceName);

        if (is_numeric($servicePort)) {
            $serviceBackend->port()->setNumber($servicePort);
        } else {
            $serviceBackend->port()->setName($servicePort);
        }

        $backend->setService($serviceBackend);

        return $backend;
    }

    public function fromServiceClassAndPort(string $serviceClass, int|string $servicePort): IngressBackend
    {
        $serviceName = $this->app->namesHelper()->byServiceClass($serviceClass);

        return $this->fromServiceNameAndPort($serviceName, $servicePort);
    }

    public function fromManifestReference(ManifestReference $manifestReference): IngressBackend
    {
        $backend = $this->ingressBackend ?? new IngressBackend();
        $resource = $this->manifestReferenceUtil->toTypedLocalObjectReference($manifestReference);
        $backend->setResource($resource);

        return $backend;
    }
}
