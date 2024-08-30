<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\Api\Networking\V1\Ingress;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Ingress\IngressInterface;

readonly class IngressGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated.ingress';

    public function __construct(private IngressInterface $manifest, private Ingress $ingress, private AppInterface $app)
    {
    }

    public function manifest(): IngressInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->ingress;
    }

    public function ingress(): Ingress
    {
        return $this->ingress;
    }

    public function app(): AppInterface
    {
        return $this->app;
    }
}
