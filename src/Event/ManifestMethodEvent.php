<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ManifestMethodEvent extends AbstractProxyableMethodEvent
{
    public const NAME = 'dealroadshow_k8s.manifest.before_method';

    public function __construct(ManifestInterface&ProxyInterface $proxyable, string $methodName, array $methodParams)
    {
        parent::__construct($proxyable, $methodName, $methodParams);
    }

    public function manifest(): ManifestInterface
    {
        return $this->proxyable;
    }
}
