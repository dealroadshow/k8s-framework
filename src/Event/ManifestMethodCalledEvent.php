<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ManifestMethodCalledEvent extends ManifestMethodEvent implements ProxyableMethodCalledEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest.method_called';

    public function __construct(ManifestInterface&ProxyInterface $manifest, string $methodName, array $methodParams, private readonly mixed $returnedValue)
    {
        parent::__construct($manifest, $methodName, $methodParams);
    }

    public function returnedValue(): mixed
    {
        return $this->returnedValue;
    }
}
