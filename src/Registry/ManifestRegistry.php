<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Registry\Query\ManifestsQuery;

class ManifestRegistry
{
    /**
     * @var iterable|ManifestInterface[]
     */
    private iterable $manifests;

    /**
     * @param iterable|ManifestInterface[] $manifests
     */
    public function __construct(iterable $manifests)
    {
        $this->manifests = $manifests;
    }

    /**
     * @return iterable|ManifestInterface[]
     */
    public function all(): iterable
    {
        return $this->manifests;
    }

    /**
     * @param AppInterface $app
     *
     * @return iterable|ManifestInterface[]
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
