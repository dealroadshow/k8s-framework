<?php

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Config\ConfigAwareTrait;
use Dealroadshow\K8S\Framework\Core\ManifestFile;
use Dealroadshow\K8S\Framework\Helper\Metadata\MetadataHelperInterface;
use Dealroadshow\K8S\Framework\Helper\Names\NamesHelperInterface;

abstract class AbstractApp implements AppInterface
{
    use ConfigAwareTrait;

    protected array $files = [];

    public function __construct(
        protected MetadataHelperInterface $metadataHelper,
        protected NamesHelperInterface $namesHelper
    ) {
    }

    public function addManifestFile(string $fileNameWithoutExtension, APIResourceInterface $resource): void
    {
        if (array_key_exists($fileNameWithoutExtension, $this->files)) {
            throw new \LogicException(
                sprintf(
                    'Filename "%s" for app "%s" is already reserved by "%s" instance',
                    $fileNameWithoutExtension,
                    static::name(),
                    get_class($this->files[$fileNameWithoutExtension])
                )
            );
        }
        $this->files[$fileNameWithoutExtension] = new ManifestFile($fileNameWithoutExtension, $resource);
    }

    public function manifestNamePrefix(): string
    {
        return static::name();
    }

    public function manifestFiles(): iterable
    {
        return $this->files;
    }

    public function metadataHelper(): MetadataHelperInterface
    {
        $this->metadataHelper->setApp($this);

        return $this->metadataHelper;
    }

    public function namesHelper(): NamesHelperInterface
    {
        $this->namesHelper->setApp($this);

        return $this->namesHelper;
    }

    public function config(): array
    {
        return $this->config;
    }
}
