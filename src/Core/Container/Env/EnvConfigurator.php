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
use Dealroadshow\K8S\Framework\Core\Container\Resources\ContainerResourcesField;
use Dealroadshow\K8S\Framework\Core\Pod\PodField;

class EnvConfigurator
{
    private EnvVarList $vars;
    private EnvFromSourceList $sources;
    private AppInterface $app;

    public function __construct(EnvVarList $vars, EnvFromSourceList $sources, AppInterface $app)
    {
        $this->vars = $vars;
        $this->sources = $sources;
        $this->app = $app;
    }

    public function addConfigMap(string $configMapClass, bool $mustExist = true, string $varNamesPrefix = null): self
    {
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

    public function addSecret(string $secretClass, bool $mustExist = true): self
    {
        $secretName = $this->app->namesHelper()->bySecretClass($secretClass);
        $envFromSource = new EnvFromSource();
        $envFromSource->secretRef()
            ->setName($secretName)
            ->setOptional(!$mustExist);

        $this->sources->add($envFromSource);

        return $this;
    }

    public function var(string $name, string $value): self
    {
        $var = new EnvVar($name);
        $var->setValue($value);

        $this->vars->add($var);

        return $this;
    }

    public function varFromConfigMap(string $varName, string $configMapClass, string $configMapKey, bool $optional = false): self
    {
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

    public function varFromSecret(string $varName, string $secretClass, string $secretKey, bool $optional = false): self
    {
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

    public function varFromPod(string $varName, PodField $podField): self
    {
        $fieldSelector = $podField->selector();

        $var = new EnvVar($varName);
        $var->valueFrom()->setFieldRef($fieldSelector);
        $this->vars->add($var);

        return $this;
    }

    public function varFromContainerResources(string $varName, ContainerResourcesField $field): self
    {
        $fieldSelector = $field->selector();

        $var = new EnvVar($varName);
        $var->valueFrom()->setResourceFieldRef($fieldSelector);
        $this->vars->add($var);

        return $this;
    }
}
