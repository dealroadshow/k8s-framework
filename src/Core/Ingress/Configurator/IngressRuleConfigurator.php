<?php

namespace Dealroadshow\K8S\Framework\Core\Ingress\Configurator;

use Dealroadshow\K8S\Data\HTTPIngressPath;
use Dealroadshow\K8S\Data\IngressRule;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\Http\PathType;
use Dealroadshow\K8S\Framework\Util\ManifestReferenceUtil;

class IngressRuleConfigurator
{
    public function __construct(
        private IngressRule $rule,
        private AppInterface $app,
        private ManifestReferenceUtil $manifestReferenceUtil
    ) {
    }

    public function addPath(PathType $pathType, string $path = null): HttpIngressPathConfigurator
    {
        if (
            null === $path
            && in_array(
                $pathType->toString(),
                [
                    PathType::exact()->toString(),
                    PathType::prefix()->toString()
                ]
            )
        ) {
            throw new \InvalidArgumentException(
                'Argument $path cannot be null if $pathType is "Exact" or "Prefix"'
            );
        }

        $ingressPath = new HTTPIngressPath($pathType->toString());
        $this->rule->http()->paths()->add($ingressPath);

        if ($path) {
            $ingressPath->setPath($path);
        }

        return new HttpIngressPathConfigurator(
            path: $ingressPath,
            app: $this->app,
            manifestReferenceUtil: $this->manifestReferenceUtil
        );
    }
}
