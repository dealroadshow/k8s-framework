<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App;

use Dealroadshow\K8S\APIResourceInterface;
use Dealroadshow\K8S\Framework\Config\ConfigAwareTrait;
use Dealroadshow\K8S\Framework\Core\ManifestFile;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Helper\Metadata\MetadataHelperInterface;
use Dealroadshow\K8S\Framework\Helper\Names\NamesHelperInterface;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

abstract class AbstractApp implements AppInterface
{
    use ConfigAwareTrait;

    protected string $alias;
    protected array $files = [];

    public function __construct(
        protected MetadataHelperInterface $metadataHelper,
        protected NamesHelperInterface $namesHelper,
        protected ManifestRegistry $manifestRegistry
    ) {
    }

    public function alias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    public function addManifestFile(string $fileNameWithoutExtension, APIResourceInterface $resource): void
    {
        if (array_key_exists($fileNameWithoutExtension, $this->files)) {
            throw new \LogicException(
                sprintf(
                    'Filename "%s" for app "%s" is already reserved by "%s" instance',
                    $fileNameWithoutExtension,
                    $this::name(),
                    get_class($this->files[$fileNameWithoutExtension])
                )
            );
        }
        $this->files[$fileNameWithoutExtension] = new ManifestFile($fileNameWithoutExtension, $resource);
    }

    public function manifestConfig(string $shortName): array
    {
        return $this->config['manifests'][$shortName] ?? [];
    }

    public function manifestNamePrefix(): string
    {
        return $this->alias;
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

    public function readFile(string $filePath): string
    {
        $appClass = new \ReflectionObject($this);
        $appDir = dirname($appClass->getFileName());
        $path = $appDir.'/Resources/'.ltrim($filePath, '/');
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(
                sprintf('File "%s" does not exist', $path)
            );
        }

        return file_get_contents($path);
    }

    public function ownsManifest(string $manifestClass): bool
    {
        return null !== $this->getManifest($manifestClass);
    }

    public function getManifest(string $manifestClass): ManifestInterface|null
    {
        if (!class_exists($manifestClass)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist', $manifestClass));
        }
        $shortName = $manifestClass::shortName();

        return $this->manifestRegistry->query($this->alias)
            ->instancesOf($manifestClass)
            ->shortName($shortName)
            ->getFirstResult();
    }
}
