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
use Dealroadshow\K8S\Framework\Core\Pod\PodField;
use Dealroadshow\K8S\Framework\Core\Secret\SecretInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Registry\ManifestRegistry;

class EnvConfigurator
{
    public function __construct(
        private EnvVarList $vars,
        private EnvFromSourceList $sources,
        private AppInterface $app,
        private AppRegistry $appRegistry,
        private ManifestRegistry $manifestRegistry
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
     * @param string|null $appAlias App alias, if you want to add ConfigMap / Secret from an external app
     *
     * @return $this
     */
    public function addFrom(string $className, bool $mustExist = true, string $varNamesPrefix = null, string $appAlias = null): static
    {
        $class = new \ReflectionClass($className);

        if ($class->implementsInterface(ConfigMapInterface::class)) {
            return $this->addConfigMap($className, $mustExist, $varNamesPrefix, $appAlias);
        } elseif ($class->implementsInterface(SecretInterface::class)) {
            if (null !== $varNamesPrefix) {
                throw new \LogicException(
                    sprintf(
                        '$varNamesPrefix must be specified only with config map classes, but specified with secret class "%s"',
                        $className
                    )
                );
            }

            return $this->addSecret($className, $mustExist, $appAlias);
        }

        throw new \InvalidArgumentException(
            sprintf(
                '$className must be a name of class, that implements either "%s" or "%s"',
                ConfigMapInterface::class,
                SecretInterface::class
            )
        );
    }

    /**
     * @param string      $configMapClass
     * @param bool        $mustExist
     * @param string|null $varNamesPrefix
     * @param string|null $appAlias App alias, if you want to add ConfigMap from an external app
     *
     * @return $this
     */
    public function addConfigMap(string $configMapClass, bool $mustExist = true, string $varNamesPrefix = null, string $appAlias = null): static
    {
        $app = $this->appByManifestClass($configMapClass, $appAlias);
        $cmName = $app->namesHelper()->byConfigMapClass($configMapClass);

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

    /**
     * @param string      $secretClass
     * @param bool        $mustExist
     * @param string|null $appAlias App alias, if you want to add Secret from an external app
     *
     * @return $this
     */
    public function addSecret(string $secretClass, bool $mustExist = true, string $appAlias = null): static
    {
        $app = $this->appByManifestClass($secretClass, $appAlias);
        $secretName = $app->namesHelper()->bySecretClass($secretClass);
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

    /**
     * @param string      $varName
     * @param string      $configMapClass
     * @param string      $configMapKey
     * @param bool        $optional
     * @param string|null $appAlias App alias, if you want to add variable from external ConfigMap (from another app)
     *
     * @return $this
     */
    public function varFromConfigMap(string $varName, string $configMapClass, string $configMapKey, bool $optional = false, string $appAlias = null): static
    {
        $app = $this->appByManifestClass($configMapClass, $appAlias);
        $cmName = $app->namesHelper()->byConfigMapClass($configMapClass);
        $keySelector = new ConfigMapKeySelector($configMapKey);
        $keySelector
            ->setName($cmName)
            ->setOptional($optional);

        $var = new EnvVar($varName);
        $var->valueFrom()->setConfigMapKeyRef($keySelector);
        $this->vars->add($var);

        return $this;
    }

    /**
     * @param string      $varName
     * @param string      $secretClass
     * @param string      $secretKey
     * @param bool        $optional
     * @param string|null $appAlias App alias, if you want to add variable from external Secret (from another app)
     *
     * @return $this
     */
    public function varFromSecret(string $varName, string $secretClass, string $secretKey, bool $optional = false, string $appAlias = null): static
    {
        $app = $this->appByManifestClass($secretClass, $appAlias);
        $secretName = $app->namesHelper()->bySecretClass($secretClass);
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

    private function appByManifestClass(string $manifestClassName, string|null $appAlias): AppInterface
    {
        $manifestClass = new \ReflectionClass($manifestClassName);
        $manifestKind = $manifestClass->getMethod('kind')->invoke(null);
        $appClass = new \ReflectionObject($this->app);
        if (str_starts_with($manifestClassName, $appClass->getNamespaceName())) {
            // ConfigMap/Secret class is used by manifest in a same app
            return $this->app;
        }


        if (null !== $appAlias) {
            if (!$this->appRegistry->has($appAlias)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'App "%s" for "%s" class "%s" does not exist',
                        $appAlias,
                        $manifestKind,
                        $manifestClassName
                    )
                );
            }

            return $this->appRegistry->get($appAlias);
        }

        $manifestOwningAppClass = null;
        foreach ($this->appRegistry->classes() as $appClassName) {
            $appClass = new \ReflectionClass($appClassName);
            if (str_starts_with($manifestClassName, $appClass->getNamespaceName())) {
                $manifestOwningAppClass = $appClass;
            }
        }

        if (null === $manifestOwningAppClass) {
            throw new \LogicException(
                sprintf(
                    'Cannot determine, which app owns %s class "%s". You should provide app alias as an argument',
                    $manifestKind,
                    $manifestClassName
                )
            );
        }

        $possibleManifestOwners = $this->appRegistry->allAppsByClass($manifestOwningAppClass->getName());
        if ($possibleManifestOwners instanceof \Traversable) {
            $possibleManifestOwners = iterator_to_array($possibleManifestOwners);
        }
        $possibleOwnersNumber = count($possibleManifestOwners);
        if (0 === $possibleOwnersNumber) {
            throw new \LogicException(
                sprintf(
                    '%s class "%s" is determined to be owned by app class "%s", but there are no such apps registered',
                    $manifestKind,
                    $manifestClassName,
                    $manifestOwningAppClass->getName()
                )
            );
        } elseif (1 < $possibleOwnersNumber) {
            $errMessage = <<<'ERR'
            %s class "%s" is determined to be owned by app class "%s", but there are more than one such app registered.
            In order to resolve this ambiguity, please provide an app alias as an argument.
            ERR;


            throw new \LogicException(
                sprintf(
                    str_replace(PHP_EOL, ' ', $errMessage),
                    $manifestKind,
                    $manifestClassName,
                    $manifestOwningAppClass->getName()
                )
            );
        }

        return $possibleOwnersNumber[0];
    }
}
