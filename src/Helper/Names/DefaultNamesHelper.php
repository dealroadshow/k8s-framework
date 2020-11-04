<?php

namespace Dealroadshow\K8S\Framework\Helper\Names;

use Dealroadshow\K8S\Framework\Core\AppAwareInterface;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Core\Service\ServiceInterface;
use Dealroadshow\K8S\Framework\Helper\HelperTrait;

class DefaultNamesHelper implements NamesHelperInterface
{
    use HelperTrait;

    public function format(string $name): string
    {
        return sprintf(
            '%s-%s-%s',
            $this->app->env(),
            $this->app->name(),
            $name
        );
    }

    public function byManifestClass(string $manifestClass): string
    {
        if (!class_exists($manifestClass)) {
            throw new \InvalidArgumentException(
                sprintf('Class "%s" does not exist', $manifestClass)
            );
        }

        if (!is_subclass_of($manifestClass, ManifestInterface::class, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$manifestClass must be a name of class that implements %s, given class "%s" does not',
                    ManifestInterface::class,
                    $manifestClass
                )
            );
        }

        $manifest = $this->makeManifest($manifestClass);

        return $this->format($manifest->name());
    }

    public function byConfigMapClass(string $configMapClass): string
    {
        return $this->byExpectedClassName(
            $configMapClass,
            ConfigMapInterface::class,
            __METHOD__
        );
    }

    public function bySecretClass(string $configMapClass): string
    {
        return $this->byExpectedClassName(
            $configMapClass,
            SecretInterface::class,
            __METHOD__
        );
    }

    public function byServiceClass(string $serviceClass): string
    {
        return $this->byExpectedClassName(
            $serviceClass,
            ServiceInterface::class,
            __METHOD__
        );
    }

    private function byExpectedClassName(string $actualClass, string $expectedClass, string $methodName): string
    {
        if (!class_exists($actualClass)) {
            throw new \InvalidArgumentException(
                sprintf('Class "%s" does not exist.', $actualClass)
            );
        }

        if (!is_subclass_of($actualClass, $expectedClass, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Class "%s" must implement "%s" to be used as an argument to %s()',
                    $actualClass,
                    $expectedClass,
                    $methodName
                )
            );
        }

        return $this->byManifestClass($actualClass);
    }

    private function makeManifest(string $manifestClass): ManifestInterface
    {
        $manifest = new $manifestClass;
        if($manifest instanceof AppAwareInterface) {
            $manifest->setApp($this->app);
        }

        return $manifest;
    }
}
