<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Proxy\ManifestProxyFactory;
use Dealroadshow\K8S\Framework\Registry\Query\ManifestsQuery;
use ProxyManager\Proxy\AccessInterceptorInterface;

class ManifestRegistry
{
    /**
     * @var ManifestInterface[][]
     */
    private array $manifests = [];

    public function __construct(private ManifestProxyFactory $proxyFactory)
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

        $key = sprintf('%s_%s', $manifest::shortName(), $manifest::kind());
        if (array_key_exists($key, $this->manifests[$appAlias])) {
            $existingManifestClass = new \ReflectionClass($this->manifests[$appAlias][$key]);
            if ($existingManifestClass->implementsInterface(AccessInterceptorInterface::class)) {
                $existingManifestClass = $existingManifestClass->getParentClass();
            }
            throw new \LogicException(
                sprintf(
                    'Manifests classes "%s" and "%s" have the same kind and short name, but this is forbidden.',
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
        if (!array_key_exists($appAlias, $this->manifests)) {
            throw new \InvalidArgumentException(
                sprintf('There is no manifests for app "%s"', $appAlias)
            );
        }
        $manifests = $this->manifests[$appAlias];

        return new ManifestsQuery($manifests);
    }
}
