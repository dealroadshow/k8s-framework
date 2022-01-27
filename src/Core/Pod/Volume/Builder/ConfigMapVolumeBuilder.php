<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder;

use Dealroadshow\K8S\Data\ConfigMapVolumeSource;
use Dealroadshow\K8S\Data\KeyToPath;
use Dealroadshow\K8S\Data\Volume;

class ConfigMapVolumeBuilder extends AbstractVolumeBuilder
{
    private string $configMapName;
    private ConfigMapVolumeSource $source;

    public function __construct(string $configMapName)
    {
        $this->configMapName = $configMapName;
    }

    public function init(Volume $volume): void
    {
        $this->source = $volume->configMap();
        $this->source->setName($this->configMapName);
    }

    public function mapKeyToPath(string $key, string $path): self
    {
        $keyToPath = new KeyToPath($key, $path);
        $this->source->items()->add($keyToPath);

        return $this;
    }

    public function setOptional(bool $optional): self
    {
        $this->source->setOptional($optional);

        return $this;
    }

    public function setDefaultMode(int $mode): self
    {
        $this->source->setDefaultMode($mode);

        return $this;
    }
}
