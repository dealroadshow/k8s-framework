<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Env;

use Dealroadshow\K8S\Data\Collection\EnvFromSourceList;
use Dealroadshow\K8S\Data\Collection\EnvVarList;
use Dealroadshow\K8S\Data\ConfigMapEnvSource;
use Dealroadshow\K8S\Data\ConfigMapKeySelector;
use Dealroadshow\K8S\Data\EnvFromSource;
use Dealroadshow\K8S\Data\EnvVar;
use Dealroadshow\K8S\Data\SecretKeySelector;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ConfigMap\ConfigMapInterface;
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesField;
use Dealroadshow\K8S\Framework\Core\ManifestManager;
use Dealroadshow\K8S\Framework\Core\Pod\PodField;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

class EnvConfigurator
{
    public function __construct(
        private EnvVarList $vars,
        private EnvFromSourceList $sources,
        private AppInterface $app,
        private AppRegistry $appRegistry,
        private ManifestManager $manifestManager
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
        $source = new ConfigMapEnvSource();
        $source
            ->setName($cmName)
            ->setOptional(!$mustExist);
        $envFromSource = new EnvFromSource();
        if (null !== $varNamesPrefix) {
            $envFromSource->setPrefix($varNamesPrefix);
        }
        $envFromSource->configMapRef()
            ->setName($cmName)
            ->setOptional(!$mustExist);

        $this->sources->add($envFromSource);

        return $this;
    }

    public function addSecret(string $secretClass, bool $mustExist = true): static
    {
        $this->ensureAppOwnsManifestClass($secretClass);
        $secretName = $this->app->namesHelper()->bySecretClass($secretClass);
        $envFromSource = new EnvFromSource();
        $envFromSource->secretRef()
            ->setName($secretName)
            ->setOptional(!$mustExist);

        $this->sources->add($envFromSource);

        return $this;
    }

    public function var(string $name, string $value): static
    {
        $var = new EnvVar($name);
        $var->setValue($value);

        $this->vars->add($var);

        return $this;
    }

    public function varFromConfigMap(string $varName, string $configMapClass, string $configMapKey, bool $optional = false): static
    {
        $this->ensureAppOwnsManifestClass($configMapClass);
        $cmName = $this->app->namesHelper()->byConfigMapClass($configMapClass);
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
        $fieldSelector = $podField->selector();

        $var = new EnvVar($varName);
        $var->valueFrom()->setFieldRef($fieldSelector);
        $this->vars->add($var);

        return $this;
    }

    public function varFromContainerResources(string $varName, ContainerResourcesField $field): static
    {
        $fieldSelector = $field->selector();

        $var = new EnvVar($varName);
        $var->valueFrom()->setResourceFieldRef($fieldSelector);
        $this->vars->add($var);

        return $this;
    }

    public function withExternalApp(string $appAlias): EnvConfigurator
    {
        return new EnvConfigurator(
            $this->vars,
            $this->sources,
            $this->appRegistry->get($appAlias),
            $this->appRegistry,
            $this->manifestManager
        );
    }

    private function ensureAppOwnsManifestClass(string $className): void
    {
        if ($this->manifestManager->appOwnsManifest($this->app->alias(), $className)) {
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
