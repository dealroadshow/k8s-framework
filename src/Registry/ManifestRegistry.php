<?php

namespace Dealroadshow\K8S\Framework\Registry;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

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
     * @param AppInterface $app
     *
     * @param string|null $className
     * @return iterable|ManifestInterface[]
     */
    public function byApp(AppInterface $app, string $className = null): iterable
    {
        $reflection = new \ReflectionObject($app);

        return $this->byNamespacePrefix($reflection->getNamespaceName(), $className);
    }

    /**
     * @param string $namespacePrefix
     *
     * @param string|null $className
     * @return iterable|ManifestInterface[]
     */
    public function byNamespacePrefix(string $namespacePrefix, string $className = null): iterable
    {
        foreach ($this->manifests as $manifest) {
            $class = get_class($manifest);
            if (str_starts_with($class, $namespacePrefix) && (null === $className || $manifest instanceof $className)) {
                yield $manifest;
            }
        }
    }
}
