<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\Proximity\ProxyInterface;

class ManifestMethodEvent
{
    public const NAME = 'dealroadshow_k8s.manifest.before_method';

    private mixed $returnValue = null;

    public function __construct(private ManifestInterface&ProxyInterface $proxy, private string $methodName, private array $methodParams)
    {
    }

    public function manifest(): ManifestInterface
    {
        return $this->proxy;
    }

    public function methodName(): string
    {
        return $this->methodName;
    }

    public function methodParams(): array
    {
        return $this->methodParams;
    }

    public function getReturnValue(): mixed
    {
        return $this->returnValue;
    }

    public function setReturnValue(mixed $returnValue): void
    {
        $this->returnValue = $returnValue;
    }
}
