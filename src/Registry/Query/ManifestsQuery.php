<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Registry\Query;

use Closure;
use Dealroadshow\K8S\Framework\Attribute\Scanner\TagsScanner;
use Dealroadshow\K8S\Framework\Core\DynamicNameAwareInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;

class ManifestsQuery
{
    /**
     * @var Closure[]
     */
    private array $closures = [];

    /**
     * @param ManifestInterface[] $manifests
     */
    public function __construct(private array $manifests)
    {
    }

    public function includeTags(array $tags): static
    {
        return $this->addClosure(
            function (ManifestInterface $manifest) use ($tags): bool {
                $manifestTags = TagsScanner::scan($manifest);
                return count(array_intersect($tags, $manifestTags)) > 0;
            }
        );
    }

    public function excludeTags(array $tags): static
    {
        return $this->addClosure(
            function (ManifestInterface $manifest) use ($tags): bool {
                $manifestTags = TagsScanner::scan($manifest);
                return count(array_intersect($tags, $manifestTags)) === 0;
            }
        );
    }

    public function instancesOf(string $className): static
    {
        return $this->addClosure(
            fn (ManifestInterface $manifest): bool => $manifest instanceof $className
        );
    }

    public function shortName(string $name): static
    {
        return $this->addClosure(
            function (ManifestInterface $manifest) use ($name): bool {
                $shortName = $manifest instanceof DynamicNameAwareInterface ? $manifest->name() : $manifest::shortName();

                return $shortName === $name;
            }
        );
    }

    /**
     * @return ManifestInterface[]
     */
    public function execute(): iterable
    {
        foreach ($this->manifests as $manifest) {
            foreach ($this->closures as $closure) {
                if (!$closure($manifest)) {
                    continue 2;
                }
            }
            yield $manifest;
        }
    }

    public function getFirstResult(): ManifestInterface|null
    {
        foreach ($this->execute() as $manifest) {
            return $manifest;
        }

        return null;
    }

    private function addClosure(Closure $closure): static
    {
        $this->closures[] = $closure;

        return $this;
    }
}
