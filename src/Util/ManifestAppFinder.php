<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Util;

use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class ManifestAppFinder
{
    public function __construct(private AppRegistry $appRegistry, private ManifestRegistry $manifestRegistry)
    {
    }

    public function appByManifestClass(string $manifestClass): AppInterface
    {
        if (!class_exists($manifestClass)) {
            throw new \InvalidArgumentException(
                sprintf('Manifest class "%s" does not exist', $manifestClass)
            );
        }
        $class = new \ReflectionClass($manifestClass);

        $candidates = [];
        foreach ($this->appRegistry->aliases() as $appAlias) {
            $manifest = $this->manifestRegistry->query($appAlias)
                ->shortName($class->getMethod('shortName')->invoke(null))
                ->instancesOf($manifestClass)
                ->getFirstResult();
            if (null !== $manifest) {
                $candidates[] = $appAlias;
            }
        }

        if (empty($candidates)) {
            throw new \RuntimeException(
                sprintf('Cannot determine what app owns manifest class "%s"', $manifestClass)
            );
        }

        if (count($candidates) > 1) {
            throw new \LogicException(
                sprintf(
                    'Cannot determine what app owns manifest class "%s", since it belongs to more than one app: "%s"',
                    $manifestClass,
                    implode('", "', $candidates)
                )
            );
        }

        return $this->appRegistry->get($candidates[0]);
    }
}
