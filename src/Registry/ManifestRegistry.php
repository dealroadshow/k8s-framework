<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\Core\DynamicNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Proxy\ProxyFactory;
use Dealroadshow\K8S\Framework\Registry\Query\ManifestsQuery;
use Dealroadshow\Proximity\ProxyInterface;

class ManifestRegistry
{
    /**
     * @var ManifestInterface[][]
     */
    private array $manifests = [];

    public function __construct(private ProxyFactory $proxyFactory)
    {
    }

    /**
     * @param string            $appAlias
     * @param ManifestInterface $manifest
     *
     * @throws \ReflectionException
     */
    public function add(string $appAlias, ManifestInterface $manifest): void
    {
        $this->manifests[$appAlias] ??= [];

        $shortName = $manifest instanceof DynamicNameAwareInterface ? $manifest->name() : $manifest::shortName();
        $key = sprintf('%s_%s', $shortName, $manifest::kind());
        if (array_key_exists($key, $this->manifests[$appAlias])) {
            $existingManifestClass = new \ReflectionClass($this->manifests[$appAlias][$key]);
            if ($existingManifestClass->implementsInterface(ProxyInterface::class)) {
                $existingManifestClass = $existingManifestClass->getParentClass();
            }
            throw new \LogicException(
                sprintf(
                    'Manifests instances of classes "%s" and "%s" have the same kind and short name, which is forbidden.',
                    $existingManifestClass->getName(),
                    $manifest::class
                )
            );
        }

        $this->manifests[$appAlias][] = $this->proxyFactory->makeProxy($manifest);
    }

    /**
     * @param string $appAlias
     *
     * @return ManifestInterface[]
     */
    public function forApp(string $appAlias): iterable
    {
        return $this->query($appAlias)->execute();
    }

    public function query(string $appAlias): ManifestsQuery
    {
        $this->manifests[$appAlias] ??= [];
        $manifests = $this->manifests[$appAlias];

        return new ManifestsQuery($manifests);
    }
}
