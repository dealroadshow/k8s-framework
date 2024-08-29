<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding;

use Dealroadshow\K8S\Api\Rbac\V1\Subject;
use Dealroadshow\K8S\Api\Rbac\V1\SubjectList;
use Dealroadshow\K8S\Framework\App\AppInterface;
use Dealroadshow\K8S\Framework\Core\Authentication\WellKnownUserOrGroup;
use Dealroadshow\K8S\Framework\Registry\AppRegistry;

readonly class SubjectsConfigurator
{
    private const API_GROUP_RBAC = 'rbac.authorization.k8s.io';

    public function __construct(
        private SubjectList $subjects,
        private AppInterface $app,
        private AppRegistry $appRegistry
    ) {
    }

    public function addGroup(WellKnownUserOrGroup|string $group): static
    {
        $groupName = $group instanceof WellKnownUserOrGroup ? $group->value : $group;
        $subject = new Subject(SubjectKind::Group->name, $groupName);
        $subject->setApiGroup(self::API_GROUP_RBAC);
        $this->subjects->add($subject);

        return $this;
    }

    public function addUser(string $name): static
    {
        $subject = new Subject(SubjectKind::User->name, $name);
        $subject->setApiGroup(self::API_GROUP_RBAC);
        $this->subjects->add($subject);

        return $this;
    }

    public function addServiceAccount(string $name, string $namespace): static
    {
        $subject = new Subject(SubjectKind::ServiceAccount->name, $name);
        $subject
            ->setNamespace($namespace)
            ->setApiGroup('');
        $this->subjects->add($subject);

        return $this;
    }

    public function addServiceAccountClass(string $serviceAccountClass, string $namespace): static
    {
        $this->ensureAppOwnsManifestClass($serviceAccountClass);
        $name = $this->app->namesHelper()->byManifestClass($serviceAccountClass);
        $this->addServiceAccount($name, $namespace);

        return $this;
    }

    public function withExternalApp(string $appAlias): static
    {
        return new self($this->subjects, $this->appRegistry->get($appAlias), $this->appRegistry);
    }

    private function ensureAppOwnsManifestClass(string $className): void
    {
        if ($this->app->ownsManifest($className)) {
            return;
        }

        $msg = <<<'ERR'
            App "%s" does not have manifests with class "%s". Please use method "%s::withExternalApp()"
            for referencing manifests from other apps.

            $subjects
                ->withExternalApp('externalAppAlias')
                ->addServiceAccountClass(MyServiceAccount::class, 'default');
            ERR;

        throw new \InvalidArgumentException(
            sprintf($msg, $this->app->alias(), $className, self::class)
        );
    }
}
