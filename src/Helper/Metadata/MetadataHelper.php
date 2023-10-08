<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Helper\Metadata;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;
use Dealroadshow\K8S\Framework\Core\DynamicNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\MetadataAwareInterface;
use Dealroadshow\K8S\Framework\Helper\HelperTrait;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;

class MetadataHelper implements MetadataHelperInterface
{
    use HelperTrait;

    public function configureMeta(MetadataAwareInterface $metadataAware, APIResourceInterface $apiObject): ObjectMeta
    {
        $meta = $apiObject->metadata();
        $metaConfigurator = new MetadataConfigurator($meta->labels(), $meta->annotations());
        $metadataAware->metadata($metaConfigurator);

        if ($metadataAware instanceof ManifestInterface) {
            $shortName = $metadataAware instanceof DynamicNameAwareInterface
                ? $metadataAware->name()
                : $metadataAware::shortName();
            $name = $this->app->namesHelper()->fullName($shortName);
            $meta->setName($name);
        }

        return $meta;
    }
}
