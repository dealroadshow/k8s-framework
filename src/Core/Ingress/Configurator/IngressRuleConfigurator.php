<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Composer\Semver\Comparator;
use Dealroadshow\K8S\Api\Networking\V1\HTTPIngressPath;
use Dealroadshow\K8S\Api\Networking\V1\IngressRule;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Http\PathType;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ManifestReferencesService;
use Dealroadshow\K8S\K8SApi;

readonly class IngressRuleConfigurator
{
    public function __construct(
        private IngressRule $rule,
        private AppInterface $app,
        private ManifestReferencesService $referencesService,
        private AppRegistry $appRegistry,
    ) {
    }

    public function addPath(PathType $pathType, string|null $path = null): HttpIngressPathConfigurator
    {
        if (
            null === $path
            && in_array(
                $pathType->toString(),
                [
                    PathType::exact()->toString(),
                    PathType::prefix()->toString(),
                ]
            )
        ) {
            throw new \InvalidArgumentException(
                'Argument $path cannot be null if $pathType is "Exact" or "Prefix"'
            );
        }

        $ingressPath = $this->createPath($pathType);
        $this->rule->http()->paths()->add($ingressPath);

        if ($path) {
            $ingressPath->setPath($path);
        }

        return new HttpIngressPathConfigurator(
            path: $ingressPath,
            app: $this->app,
            referencesService: $this->referencesService,
            appRegistry: $this->appRegistry
        );
    }

    private function createPath(PathType $pathType): HTTPIngressPath
    {
        if (Comparator::greaterThanOrEqualTo(K8SApi::VERSION, 'v1.22.0')) {
            return new HTTPIngressPath($pathType->toString());
        }

        $path = new HTTPIngressPath($pathType->toString());

        return $path;
    }
}
