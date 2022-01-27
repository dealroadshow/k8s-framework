<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core;

use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class ManifestManager
{
    public function __construct(private AppRegistry $appRegistry, private ManifestRegistry $manifestRegistry)
    {
    }

    public function appOwnsManifest(string $appAlias, string $manifestClass): bool
    {
        $manifestClass = new \ReflectionClass($manifestClass);
        $shortName = $manifestClass->getMethod('shortName')->invoke(null);
        $manifest = $this->manifestRegistry->query($appAlias)
            ->instancesOf($manifestClass->getName())
            ->shortName($shortName)
            ->getFirstResult();

        return null !== $manifest;
    }
}
