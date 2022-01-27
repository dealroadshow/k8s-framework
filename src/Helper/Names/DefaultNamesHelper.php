<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Helper\Names;

use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Core\Service\ServiceInterface;
use Dealroadshow\K8S\Framework\Helper\HelperTrait;

class DefaultNamesHelper implements NamesHelperInterface
{
    use HelperTrait;

    public function fullName(string $shortName): string
    {
        $name = '';
        if ($prefix = $this->app->manifestNamePrefix()) {
            $name = $prefix;
        }
        $name .= '-'.$shortName;

        $this->ensureValidNameLength($name);

        return $name;
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

        return $this->fullName($manifestClass::shortName());
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

    protected function ensureValidNameLength(string $name): void
    {
        $nameLength = mb_strlen($name);
        if ($nameLength > 52) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Resource name in Kubernetes is limited to 52 characters, but name "%s" is %d characters long',
                    $name,
                    $nameLength
                )
            );
        }
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
}
