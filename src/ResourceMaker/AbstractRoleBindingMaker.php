<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\ResourceMaker;

use Dealroadshow\K8S\Api\Rbac\V1\ClusterRoleBinding;
use Dealroadshow\K8S\Api\Rbac\V1\RoleBinding;
use Dealroadshow\K8S\Api\Rbac\V1\RoleRef;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\ManifestInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\ClusterRoleBindingInterface;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding\RoleRefConfigurator;
use Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding\SubjectsConfigurator;
use Dealroadshow\K8S\Framework\Core\Rbac\RoleBindingInterface;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;
use Dealroadshow\K8S\Framework\Util\ClassName;

abstract class AbstractRoleBindingMaker extends AbstractResourceMaker
{
    abstract protected function roleBinding(RoleRef $ref): RoleBinding|ClusterRoleBinding;

    public function __construct(private readonly AppRegistry $appRegistry)
    {
    }

    protected function makeResource(ManifestInterface|RoleBindingInterface|ClusterRoleBindingInterface $manifest, AppInterface $app): RoleBinding|ClusterRoleBinding
    {
        $roleRef = new RoleRef('', '', '');
        $roleBinding = $this->roleBinding($roleRef);
        $app->metadataHelper()->configureMeta($manifest, $roleBinding);

        $roleRefConfigurator = new RoleRefConfigurator($roleRef, $app, $this->appRegistry);
        $manifest->roleRef($roleRefConfigurator);
        if (in_array('', [$roleRef->getName(), $roleRef->getApiGroup(), $roleRef->getKind()])) {
            throw new \RuntimeException(sprintf('RoleRef is not configured properly, you must configure it in method %s::roleRef()', ClassName::real($manifest)));
        }

        $subjectsConfigurator = new SubjectsConfigurator($roleBinding->subjects(), $app, $this->appRegistry);
        $manifest->subjects($subjectsConfigurator);
        if (0 === $roleBinding->subjects()->count()) {
            throw new \RuntimeException(sprintf('RoleBinding has no subjects, you must configure them in method %s::subjects()', ClassName::real($manifest)));
        }

        return $roleBinding;
    }
}
