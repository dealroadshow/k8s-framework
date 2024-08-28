<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding;

use Dealroadshow\K8S\API\Rbac\ClusterRole;
use Dealroadshow\K8S\API\Rbac\Role;
use Dealroadshow\K8S\Data\RoleRef;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

readonly class RoleRefConfigurator
{
    public function __construct(
        private RoleRef $ref,
        private AppInterface $app,
        private AppRegistry $appRegistry
    ) {
        $apiGroup = substr(Role::API_VERSION, 0, strpos(Role::API_VERSION, '/'));
        $ref->setApiGroup($apiGroup);
    }

    public function fromRoleName(string $roleName): void
    {
        $this->ref->setKind(Role::KIND)->setName($roleName);
    }

    public function fromClusterRoleName(string $clusterRoleName): void
    {
        $this->ref->setKind(ClusterRole::KIND)->setName($clusterRoleName);
    }

    public function fromRoleClass(string $roleClass): void
    {
        $this->ensureAppOwnsManifestClass($roleClass);
        $name = $this->app->namesHelper()->byManifestClass($roleClass);

        $this->fromRoleName($name);
    }

    public function fromClusterRoleClass(string $clusterRoleClass): void
    {
        $this->ensureAppOwnsManifestClass($clusterRoleClass);
        $name = $this->app->namesHelper()->byManifestClass($clusterRoleClass);

        $this->fromClusterRoleName($name);
    }

    public function withExternalApp(string $appAlias): RoleRefConfigurator
    {
        return new RoleRefConfigurator($this->ref, $this->appRegistry->get($appAlias), $this->appRegistry);
    }

    private function ensureAppOwnsManifestClass(string $className): void
    {
        if ($this->app->ownsManifest($className)) {
            return;
        }

        $msg = <<<'ERR'
            App "%s" does not have manifests with class "%s". Please use method "%s::withExternalApp()"
            for referencing manifests from other apps.

            $ref->withExternalApp('externalAppAlias')->fromRoleClass(MyRole::class)
            ERR;

        throw new \InvalidArgumentException(
            sprintf($msg, $this->app->alias(), $className, self::class)
        );
    }
}
