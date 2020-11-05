<?php

namespace Dealroadshow\K8S\Framework\Registry\Query;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Attribute\Scanner\TagsScanner;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class ManifestsQuery
{
    private ManifestRegistry $registry;

    /**
     * @var ManifestInterface[]|iterable
     */
    private iterable $result;

    /**
     * @var array|\Closure[]
     */
    private array $closures;

    public function __construct(ManifestRegistry $registry)
    {
        $this->registry = $registry;
        $this->result = $registry->all();
        $this->closures = [];
    }

    public function app(AppInterface $app): self
    {
        $reflection = new \ReflectionObject($app);

        return $this->namespacePrefix($reflection->getNamespaceName());
    }

    public function includeTags(array $tags): self
    {
        return $this->addClosure(
            function (ManifestInterface $manifest) use ($tags): bool {
                $manifestTags = TagsScanner::scan($manifest);
                return count(array_intersect($tags, $manifestTags)) > 0;
            }
        );
    }

    public function excludeTags(array $tags): self
    {
        return $this->addClosure(
            function (ManifestInterface $manifest) use ($tags): bool {
                $manifestTags = TagsScanner::scan($manifest);
                return count(array_intersect($tags, $manifestTags)) === 0;
            }
        );
    }

    public function namespacePrefix(string $prefix): self
    {
        return $this->addClosure(
            fn (ManifestInterface $manifest): bool => str_starts_with(get_class($manifest), $prefix)
        );
    }

    public function instancesOf(string $className): self
    {
        return $this->addClosure(
            fn (ManifestInterface $manifest): bool => $manifest instanceof $className
        );
    }

    public function shortName(string $name): self
    {
        return $this->addClosure(
            fn (ManifestInterface $manifest): bool => $manifest::shortName() === $name
        );
    }

    /**
     * @return iterable|ManifestInterface[]
     */
    public function execute(): iterable
    {
        foreach ($this->result as $manifest) {
            foreach ($this->closures as $closure) {
                if (!$closure($manifest)) {
                    continue 2;
                }
            }
            yield $manifest;
        }
    }

    public function getFirstResult(): ?ManifestInterface
    {
        foreach ($this->execute() as $manifest) {
            return $manifest;
        }

        return null;
    }

    private function addClosure(\Closure $closure): self
    {
        $this->closures[] = $closure;

        return $this;
    }
}
