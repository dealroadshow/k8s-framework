<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\App\Integration;

class ExternalEnvSourcesRegistry
{
    private array $sources = [];

    public function trackDependency(string $dependentAppAlias, string $dependencyAppAlias, string $manifestClass): void
    {
        $this->sources[$dependentAppAlias][$dependencyAppAlias][$manifestClass] = null;
    }

    /**
     * @return array A map where each key is an app alias, and value is an array where each key
     * is an app alias of a dependency of top-level key app, and value is an array of manifest classes
     * top-level key app depends on.
     *
     * Example:
     * [
     * 'app1' => [
     *      // 'app1' depends on App2ManifestOne and App2ManifestTwo manifests from 'app2'
     *     'app2' => [App2ManifestOne::class, App2ManifestTwo::class],
     *     'app3' => [App3ManifestOne::class],
     * ]
     */
    public function getForAllApps(): array
    {
        $sources = [];
        foreach ($this->sources as $dependentAppAlias => $dependencyApps) {
            foreach ($dependencyApps as $dependencyAppAlias => $manifests) {
                $sources[$dependentAppAlias][$dependencyAppAlias] = array_keys($manifests);
            }
        }

        return $sources;
    }

    /**
     * @return array An array where each key is an app alias of a dependency of the app,
     * specified by $appAlias, and value is an array of manifest classes specified app depends on.
     * Example:
     * [
     *     // App with alias $appAlias depends on App2ManifestOne and App2ManifestTwo manifests from 'app2'
     *     // and on App3ManifestOne from 'app3'
     *     'app2' => [App2ManifestOne::class, App2ManifestTwo::class],
     *     'app3' => [App3ManifestOne::class],
     * ]
     */
    public function getForApp(string $appAlias): array
    {
        $sources = [];
        foreach (($this->sources[$appAlias] ?? []) as $dependencyAppAlias => $manifests) {
            $sources[$dependencyAppAlias] = array_keys($manifests);
        }

        return $sources;
    }
}
