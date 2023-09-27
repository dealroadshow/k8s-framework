<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\K8S\Data\CrossVersionObjectReference;
use Dealroadshow\K8S\Framework\Core\VersionedManifestReference;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

readonly class VersionedManifestReferencesService
{
    public function __construct(private AppRegistry $appRegistry)
    {
    }

    public function toCrossVersionObjectReference(VersionedManifestReference $reference): CrossVersionObjectReference
    {
        $app = $this->appRegistry->get($reference->appAlias);
        $name = $app->namesHelper()->byManifestClass($reference->className);

        $class = new \ReflectionClass($reference->className);
        $kind = $class->getMethod('kind')->invoke(null);
        $apiVersion = $reference->apiVersion ?: $class->getMethod('apiVersion')->invoke(null);

        $ref = new CrossVersionObjectReference($kind, $name);
        $ref->setApiVersion($apiVersion);

        return $ref;
    }
}
