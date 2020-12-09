<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Proxy\ManifestProxyFactory;
use Dealroadshow\K8S\Framework\Registry\Query\ManifestsQuery;

class ManifestRegistry
{
    /**
     * @var ManifestInterface[]
     */
    private array $manifests = [];

    /**
     * @param ManifestInterface[]  $manifests
     * @param ManifestProxyFactory $proxyFactory
     */
    public function __construct(iterable $manifests, ManifestProxyFactory $proxyFactory)
    {
        foreach ($manifests as $key => $manifest) {
            $this->manifests[$key] = $proxyFactory->makeProxy($manifest);
        }
    }

    /**
     * @return ManifestInterface[]
     */
    public function all(): iterable
    {
        return $this->manifests;
    }

    /**
     * @param AppInterface $app
     *
     * @return ManifestInterface[]
     */
    public function byApp(AppInterface $app): iterable
    {
        return $this->query()->app($app)->execute();
    }

    public function query(): ManifestsQuery
    {
        return new ManifestsQuery($this);
    }
}
