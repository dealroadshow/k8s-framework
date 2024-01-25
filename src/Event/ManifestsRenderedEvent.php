<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Event;

class ManifestsRenderedEvent
{
    public const NAME = 'dealroadshow_k8s.manifests.rendered';

    public function __construct(public readonly array $renderedManifests)
    {
    }
}
