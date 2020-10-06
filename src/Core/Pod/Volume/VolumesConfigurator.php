<?php

namespace Dealroadshow\K8S\Framework\Core\Pod\Volume;

use Dealroadshow\K8S\Data\Collection\VolumeList;
use Dealroadshow\K8S\Data\Volume;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder\ConfigMapVolumeBuilder;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder\DownwardAPIVolumeBuilder;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder\EmptyDirVolumeBuilder;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder\SecretVolumeBuilder;
use Dealroadshow\K8S\Framework\Core\Pod\Volume\Builder\VolumeBuilderInterface;

class VolumesConfigurator
{
    private VolumeList $volumes;
    private AppInterface $app;

    public function __construct(VolumeList $volumes, AppInterface $app)
    {
        $this->volumes = $volumes;
        $this->app = $app;
    }

    public function fromConfigMap(string $volumeName, string $configMapClass): ConfigMapVolumeBuilder
    {
        $cmName = $this->app->namesHelper()->byConfigMapClass($configMapClass);
        $builder = new ConfigMapVolumeBuilder($cmName);

        return $this->initBuilder($builder, $volumeName);
    }

    public function fromEmptyDir(string $volumeName): EmptyDirVolumeBuilder
    {
        $builder = new EmptyDirVolumeBuilder();

        return $this->initBuilder($builder, $volumeName);
    }

    public function fromDownwardAPI(string $volumeName): DownwardAPIVolumeBuilder
    {
        $builder = new DownwardAPIVolumeBuilder();

        return $this->initBuilder($builder, $volumeName);
    }

    public function fromSecret(string $volumeName, string $secretClass): SecretVolumeBuilder
    {
        $secretName = $this->app->namesHelper()->bySecretClass($secretClass);
        $builder = new SecretVolumeBuilder($secretName);

        return $this->initBuilder($builder, $volumeName);
    }

    private function createVolume(string $name): Volume
    {
        $volume = new Volume($name);
        $this->volumes->add($volume);

        return $volume;
    }

    /**
     * @param VolumeBuilderInterface $builder
     * @param string                 $volumeName
     *
     * @return ConfigMapVolumeBuilder|SecretVolumeBuilder|DownwardAPIVolumeBuilder|EmptyDirVolumeBuilder
     */
    private function initBuilder(VolumeBuilderInterface $builder, string $volumeName): VolumeBuilderInterface
    {
        $volume = $this->createVolume($volumeName);
        $builder->init($volume);

        return $builder;
    }
}
