<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Env;

class ExternalConfigurationRegistry
{
    /**
     * @var array<string, false> An array, where keys are names of Kubernetes ConfigMaps that are external, which means they are optional during the generation of manifests, and values are false booleans (ignored)
     */
    private array $configMaps = [];

    /**
     * @var array<string, false> An array, where keys are names of Kubernetes Secrets that are external, which means they are optional during the generation of manifests, and values are false booleans (ignored)
     */
    private array $secrets = [];

    public function addConfigMap(string $configMapName): void
    {
        $this->configMaps[$configMapName] = false;
    }

    public function hasConfigMap(string $configMapName): bool
    {
        return array_key_exists($configMapName, $this->configMaps);
    }

    public function addSecret(string $secretName): void
    {
        $this->secrets[$secretName] = false;
    }

    public function hasSecret(string $secretName): bool
    {
        return array_key_exists($secretName, $this->secrets);
    }
}
