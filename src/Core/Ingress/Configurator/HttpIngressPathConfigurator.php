<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\HTTPIngressPath;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ManifestReferencesService;

readonly class HttpIngressPathConfigurator
{
    public function __construct(
        private HTTPIngressPath $path,
        private AppInterface $app,
        private ManifestReferencesService $referencesService,
        private AppRegistry $appRegistry
    ) {
    }

    public function backend(): IngressBackendConfigurator
    {
        return new IngressBackendConfigurator(
            app: $this->app,
            appRegistry: $this->appRegistry,
            referencesService: $this->referencesService,
            backend: $this->path->backend()
        );
    }
}
