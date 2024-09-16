<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Env;

use Dealroadshow\K8S\Api\Core\V1\ConfigMapEnvSource;
use Dealroadshow\K8S\Api\Core\V1\ConfigMapKeySelector;
use Dealroadshow\K8S\Api\Core\V1\EnvFromSource;
use Dealroadshow\K8S\Api\Core\V1\EnvFromSourceList;
use Dealroadshow\K8S\Api\Core\V1\EnvVar;
use Dealroadshow\K8S\Api\Core\V1\EnvVarList;
use Dealroadshow\K8S\Api\Core\V1\SecretKeySelector;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\App\Integration\ExternalEnvSourcesRegistry;
use Dealroadshow\K8S\Framework\App\Integration\ExternalEnvSourcesTrackingContext;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesField;
use Dealroadshow\K8S\Framework\Core\Pod\PodField;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

readonly class EnvConfigurator
{
    public function __construct(
        private EnvVarList $vars,
        private EnvFromSourceList $sources,
        private AppInterface $app,
        private AppRegistry $appRegistry,
        private ExternalEnvSourcesRegistry $externalEnvSourcesRegistry,
        private ExternalEnvSourcesTrackingContext|null $externalEnvSourcesTrackingContext = null
    ) {
    }

    public function addFromClasses(string ...$classes): static
    {
        foreach ($classes as $class) {
            $this->addFrom($class);
        }

        return $this;
    }

    /**
     * @param string      $className      class name of a ConfigMap or a Secret
     * @param bool        $mustExist
     * @param string|null $varNamesPrefix allowed only for configmaps
     *
     * @return $this
     */
    public function addFrom(string $className, bool $mustExist = true, string $varNamesPrefix = null): static
    {
        $class = new \ReflectionClass($className);

        if ($class->implementsInterface(ConfigMapInterface::class)) {
            return $this->addConfigMap($className, $mustExist, $varNamesPrefix);
        } elseif ($class->implementsInterface(SecretInterface::class)) {
            if (null !== $varNamesPrefix) {
                throw new \LogicException(
                    sprintf(
                        '$varNamesPrefix must be specified only with config map classes, but specified with secret class "%s"',
                        $className
                    )
                );
            }

            return $this->addSecret($className, $mustExist);
        }

        throw new \InvalidArgumentException(
            sprintf(
                '$className must be a name of class, that implements either "%s" or "%s"',
                ConfigMapInterface::class,
                SecretInterface::class
            )
        );
    }

    public function addConfigMap(string $configMapClass, bool $mustExist = true, string $varNamesPrefix = null): static
    {
        $this->ensureAppOwnsManifestClass($configMapClass);
        $cmName = $this->app->namesHelper()->byConfigMapClass($configMapClass);
        $this->externalEnvSourcesTrackingContext?->trackDependency($configMapClass);

        return $this->addConfigMapByName($cmName, $mustExist, $varNamesPrefix);
    }

    public function addConfigMapByName(string $configMapName, bool $mustExist = true, string $varNamesPrefix = null): static
    {
        $source = new ConfigMapEnvSource();
        $source
            ->setName($configMapName)
            ->setOptional(!$mustExist);
        $envFromSource = new EnvFromSource();
        if (null !== $varNamesPrefix) {
            $envFromSource->setPrefix($varNamesPrefix);
        }
        $envFromSource->configMapRef()
            ->setName($configMapName)
            ->setOptional(!$mustExist);

        $this->sources->add($envFromSource);

        return $this;
    }

    public function addSecret(string $secretClass, bool $mustExist = true): static
    {
        $this->ensureAppOwnsManifestClass($secretClass);
        $secretName = $this->app->namesHelper()->bySecretClass($secretClass);
        $this->externalEnvSourcesTrackingContext?->trackDependency($secretClass);

        return $this->addSecretByName($secretName, $mustExist);
    }

    public function addSecretByName(string $secretName, bool $mustExist = true): static
    {
        $envFromSource = new EnvFromSource();
        $envFromSource->secretRef()
            ->setName($secretName)
            ->setOptional(!$mustExist);

        $this->sources->add($envFromSource);

        return $this;
    }

    public function var(string $name, string $value): static
    {
        $this->externalEnvSourcesTrackingContext?->throwOnInvalidMethodCall(__METHOD__);

        $var = new EnvVar($name);
        $var->setValue($value);

        $this->vars->add($var);

        return $this;
    }

    public function varFromConfigMap(string $varName, string $configMapClass, string $configMapKey, bool $optional = false): static
    {
        $this->ensureAppOwnsManifestClass($configMapClass);
        $cmName = $this->app->namesHelper()->byConfigMapClass($configMapClass);

        $this->externalEnvSourcesTrackingContext?->trackDependency($configMapClass);

        $keySelector = new ConfigMapKeySelector($configMapKey);
        $keySelector
            ->setName($cmName)
            ->setOptional($optional);

        $var = new EnvVar($varName);
        $var->valueFrom()->setConfigMapKeyRef($keySelector);
        $this->vars->add($var);

        return $this;
    }

    public function varFromSecret(string $varName, string $secretClass, string $secretKey, bool $optional = false): static
    {
        $this->ensureAppOwnsManifestClass($secretClass);
        $secretName = $this->app->namesHelper()->bySecretClass($secretClass);

        $this->externalEnvSourcesTrackingContext?->trackDependency($secretClass);

        $keySelector = new SecretKeySelector($secretKey);
        $keySelector
            ->setName($secretName)
            ->setOptional($optional);

        $var = new EnvVar($varName);
        $var->valueFrom()->setSecretKeyRef($keySelector);
        $this->vars->add($var);

        return $this;
    }

    public function varFromPod(string $varName, PodField $podField): static
    {
        $this->externalEnvSourcesTrackingContext?->throwOnInvalidMethodCall(__METHOD__);

        $fieldSelector = $podField->selector();

        $var = new EnvVar($varName);
        $var->valueFrom()->setFieldRef($fieldSelector);
        $this->vars->add($var);

        return $this;
    }

    public function varFromContainerResources(string $varName, ContainerResourcesField $field): static
    {
        $this->externalEnvSourcesTrackingContext?->throwOnInvalidMethodCall(__METHOD__);

        $fieldSelector = $field->selector();

        $var = new EnvVar($varName);
        $var->valueFrom()->setResourceFieldRef($fieldSelector);
        $this->vars->add($var);

        return $this;
    }

    public function withExternalApp(string $appAlias): EnvConfigurator
    {
        $this->externalEnvSourcesTrackingContext?->throwOnInvalidMethodCall(__METHOD__);

        return new EnvConfigurator(
            $this->vars,
            $this->sources,
            $this->appRegistry->get($appAlias),
            $this->appRegistry,
            $this->externalEnvSourcesRegistry,
            new ExternalEnvSourcesTrackingContext($this->app->alias(), $appAlias, $this->externalEnvSourcesRegistry)
        );
    }

    private function ensureAppOwnsManifestClass(string $className): void
    {
        if ($this->app->ownsManifest($className)) {
            return;
        }

        $msg = <<<'ERR'
            App "%s" does not have manifests with class "%s". Please use method "%s::withExternalApp()"
            for adding configmaps or secrets from another app. Example:

            $env->withExternalApp('externalAppAlias')
                ->addConfigMap(MyConfigMap::class)
                ->addSecret(MySecret::class)
            ;
            ERR;

        throw new \InvalidArgumentException(
            sprintf($msg, $this->app->alias(), $className, EnvConfigurator::class)
        );
    }
}
