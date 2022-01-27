<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\HTTPIngressPath;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

class HttpIngressPathConfigurator
{
    public function __construct(
        private HTTPIngressPath $path,
        private AppInterface $app,
        private ManifestReferenceUtil $manifestReferenceUtil
    ) {
    }

    public function backend(): IngressBackendConfigurator
    {
        return new IngressBackendConfigurator(
            app: $this->app,
            manifestReferenceUtil: $this->manifestReferenceUtil,
            backend: $this->path->backend()
        );
    }
}
