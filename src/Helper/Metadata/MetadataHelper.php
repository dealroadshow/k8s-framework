<?php

namespace Dealroadshow\K8S\Framework\Helper\Metadata;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;
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
        $metadataAware->configureMeta($metaConfigurator);

        if ($metadataAware instanceof ManifestInterface) {
            $name = $this->app->namesHelper()->fullName($metadataAware::shortName());
            $meta->setName($name);
        }

        return $meta;
    }
}
