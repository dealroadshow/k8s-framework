<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration\Localization;

/**
 * This interface represents a strategy for "localizing" ConfigMaps and Secrets
 * that some K8S app depends on from other apps. This dependency is represented
 * by the usage of `$env->withExternalApp(SomeApp::name())->addFromClasses(...)`
 * in `env()` method of the app's manifests (workloads like Deployments, StatefulSets, etc.).
 *
 * "Localization" in this context means making a dependent app independent of other apps
 * by moving values dependent app needs from external ConfigMaps and Secrets to the dependent app.
 * It can be done by generating new ConfigMaps or Secrets in the dependent app that repeats external
 * ConfigMaps and Secret, or generating some big umbrella ConfigMap or Secret that contains all values
 * dependent app needs from external ConfigMaps and Secrets. So every strategy defines its own means
 * of localization.
 *
 * Strategies will probably use @see \Dealroadshow\K8S\Framework\App\Integration\EnvSourcesRegistry
 * in order to get information about dependencies of the dependent apps.
 */
interface LocalizationStrategyInterface
{
    /**
     * @param array $dependencies An array of dependencies of the $dependentAppAlias, where each key is
     * an app alias of a dependency, and a value is an array of manifest classes the $dependentAppAlias depends on
     * from this app. For example:
     * [
     *     'app2' => [App2ManifestOne::class, App2ManifestTwo::class],
     *     'app3' => [App3ManifestOne::class],
     * ]
     */
    public function localize(string $dependentAppAlias, array $dependencies);
}
