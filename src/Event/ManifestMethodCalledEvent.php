<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ManifestMethodCalledEvent extends ManifestMethodEvent
{
    public const NAME = 'dealroadshow_k8s.manifest.method_called';

    public function __construct(ManifestInterface&ProxyInterface $proxy, string $methodName, array $methodParams, private mixed $returnedValue)
    {
        parent::__construct($proxy, $methodName, $methodParams);
    }

    public function returnedValue(): mixed
    {
        return $this->returnedValue;
    }
}
