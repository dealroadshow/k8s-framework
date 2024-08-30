<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Helper\Metadata;

use Dealroadshow\K8S\Apimachinery\Pkg\Apis\Meta\V1\ObjectMeta;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\MetadataAwareInterface;
use Dealroadshow\K8S\Framework\Helper\HelperTrait;
use Dealroadshow\K8S\Framework\Core\MetadataConfigurator;
use Dealroadshow\K8S\Framework\Util\ManifestShortName;

class MetadataHelper implements MetadataHelperInterface
{
    use HelperTrait;

    public function configureMeta(MetadataAwareInterface $metadataAware, APIResourceInterface $apiObject): ObjectMeta
    {
        $meta = $apiObject->metadata();
        $metaConfigurator = new MetadataConfigurator($meta->labels(), $meta->annotations());
        $metadataAware->metadata($metaConfigurator);

        if ($metadataAware instanceof ManifestInterface) {
            $name = $this->app->namesHelper()->fullName(ManifestShortName::getFrom($metadataAware));
            $meta->setName($name);
        }

        return $meta;
    }
}
