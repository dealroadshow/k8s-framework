<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class ManifestGeneratedEvent implements ManifestGeneratedEventInterface
{
    public const NAME = 'dealroadshow_k8s.manifest_generated';

    /**
     * @var bool If true, will prevent generated manifest from being printed / dumped and will exclude it from final manifests generation result
     */
    public bool $preventProcessing = false;

    public function __construct(private readonly ManifestInterface $manifest, private readonly APIResourceInterface $resource)
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
