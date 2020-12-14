<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Proxy\ManifestProxyFactory;
use Dealroadshow\K8S\Framework\Registry\Query\ManifestsQuery;

class ManifestRegistry
{
    /**
     * @var ManifestInterface[][]
     */
    private array $manifests = [];

    public function __construct(private ManifestProxyFactory $proxyFactory)
    {
    }

    public function add(string $appAlias, ManifestInterface $manifest): void
    {
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
