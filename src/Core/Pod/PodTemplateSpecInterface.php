<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod;

use Dealroadshow\K8S\Framework\Core\MetadataAwareInterface;

interface PodTemplateSpecInterface extends PodSpecInterface, MetadataAwareInterface
{
}
