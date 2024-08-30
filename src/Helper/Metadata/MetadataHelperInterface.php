<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Helper\Metadata;

use Dealroadshow\K8S\Apimachinery\Pkg\Apis\Meta\V1\ObjectMeta;
use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Core\MetadataAwareInterface;
use Dealroadshow\K8S\Framework\Helper\HelperInterface;

interface MetadataHelperInterface extends HelperInterface
{
    public function configureMeta(MetadataAwareInterface $metadataAware, APIResourceInterface $apiObject): ObjectMeta;
}
