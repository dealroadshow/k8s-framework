<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\VolumeMount;

use Dealroadshow\K8S\Data\VolumeMount;

class VolumeMountBuilder
{
    private VolumeMount $mount;

    public function __construct(VolumeMount $mount)
    {
        $this->mount = $mount;
    }

    public function setVolumePropagation(MountPropagation $propagation): self
    {
        $this->mount->setMountPropagation($propagation->toString());

        return $this;
    }

    public function setReadOnly(bool $readOnly): self
    {
        $this->mount->setReadOnly($readOnly);

        return $this;
    }

    public function setSubPath(string $subPath): self
    {
        $this->mount->setSubPath($subPath);

        return $this;
    }

    public function setSubPathExpression(string $subPathExpression): self
    {
        $this->mount->setSubPathExpr($subPathExpression);

        return $this;
    }
}
