<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Pod\PriorityClass;

use Dealroadshow\K8S\Data\PodSpec;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\PriorityClass\PriorityClassInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

class PriorityClassConfigurator
{
    private bool $locked = false;

    public function __construct(private PodSpec $spec, private AppInterface $app, private AppRegistry $appRegistry)
    {
    }

    public function fromPHPClass(string $phpClassName): void
    {
        $this->prohibitMultipleCalls();
        if (!class_exists($phpClassName)) {
            throw new \InvalidArgumentException(
                sprintf('Class "%s" does not exist', $phpClassName)
            );
        }
        $class = new \ReflectionClass($phpClassName);
        if (!$class->implementsInterface(PriorityClassInterface::class)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$phpClassName must be a name of class that implements "%s", given "%s"',
                    PriorityClassInterface::class,
                    $phpClassName
                )
            );
        }

        if (!$this->app->ownsManifest($phpClassName)) {
            $msg = <<<'ERR'
                App "%s" does not have manifests with class "%s". Please use method "%s::withExternalApp()"
                for using priority classes from another app. Example:

                $priorityClass->withExternalApp('externalAppAlias')->fromPHPClass(ExternalPriorityClass::class);
                ERR;

            throw new \InvalidArgumentException(
                sprintf($msg, $this->app->alias(), $phpClassName, static::class)
            );
        }

        $priorityClassName = $this->app->namesHelper()->byManifestClass($phpClassName);
        $this->spec->setPriorityClassName($priorityClassName);
    }

    public function fromPriorityClassName(string $priorityClassName): void
    {
        $this->prohibitMultipleCalls();
        $this->spec->setPriorityClassName($priorityClassName);
    }

    public function withExternalApp(string $appAlias): static
    {
        return new self($this->spec, $this->appRegistry->get($appAlias), $this->appRegistry);
    }

    private function prohibitMultipleCalls(): void
    {
        if ($this->locked) {
            $err = <<<'ERR'
                %s allows to set priority class name only once, but multiple calls detected.
                Ensure you call only one of methods "fromPHPClass()" or "fromPriorityClassName()", and only once.
                ERR;

            throw new \LogicException(sprintf($err, static::class));
        }

        $this->locked = true;
    }
}
