<?php

namespace Dealroadshow\K8S\Framework\Event;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

readonly class ManifestGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated';

    public function __construct(private ManifestInterface $manifest, private APIResourceInterface $resource)
    {
    }

    public function manifest(): ManifestInterface
    {
        return $this->manifest;
    }

    public function apiResource(): APIResourceInterface
    {
        return $this->resource;
    }
}
