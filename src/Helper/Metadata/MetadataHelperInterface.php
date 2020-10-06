<?php

namespace Dealroadshow\K8S\Framework\Helper\Metadata;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Data\ObjectMeta;
use Dealroadshow\K8S\Framework\Core\MetadataAwareInterface;
use Dealroadshow\K8S\Framework\Helper\HelperInterface;

interface MetadataHelperInterface extends HelperInterface
{
    public function configureMeta(MetadataAwareInterface $metadataAware, APIResourceInterface $apiObject): ObjectMeta;
}
