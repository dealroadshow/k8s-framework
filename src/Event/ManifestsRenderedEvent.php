<?php

namespace Dealroadshow\K8S\Framework\Event;

class ManifestsRenderedEvent
{
    public const NAME = 'dealroadshow_k8s.manifests.processed';

    public function __construct(public readonly array $renderedManifests)
    {
    }
}
