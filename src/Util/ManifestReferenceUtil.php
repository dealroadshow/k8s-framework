<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\K8S\Data\LocalObjectReference;
use Dealroadshow\K8S\Data\ObjectReference;
use Dealroadshow\K8S\Data\TypedLocalObjectReference;
use Dealroadshow\K8S\Framework\Core\ManifestReference;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

readonly class ManifestReferenceUtil
{
    public function __construct(private AppRegistry $appRegistry)
    {
    }

    public function toTypedLocalObjectReference(ManifestReference $manifestReference): TypedLocalObjectReference
    {
        $name = $this->toResourceName($manifestReference);

        $class = new \ReflectionClass($manifestReference->className());
        $kind = $class->getMethod('kind')->invoke(null);

        $objectReference = new TypedLocalObjectReference($kind, $name);
        if ($apiGroup = $manifestReference->apiGroup()) {
            $objectReference->setApiGroup($apiGroup);
        }

        return $objectReference;
    }

    public function toLocalObjectReference(ManifestReference $manifestReference): LocalObjectReference
    {
        $name = $this->toResourceName($manifestReference);

        $objectReference = new LocalObjectReference();
        $objectReference->setName($name);

        return $objectReference;
    }

    public function toObjectReference(ManifestReference $manifestReference): ObjectReference
    {
        $name = $this->toResourceName($manifestReference);

        $class = new \ReflectionClass($manifestReference->className());
        $kind = $class->getMethod('kind')->invoke(null);

        $objectReference = new ObjectReference();
        $objectReference
            ->setName($name)
            ->setKind($kind)
        ;

        return $objectReference;
    }

    public function toResourceName(ManifestReference $manifestReference): string
    {
        $app = $this->appRegistry->get($manifestReference->appAlias());

        return $app->namesHelper()->byManifestClass($manifestReference->className());
    }
}
