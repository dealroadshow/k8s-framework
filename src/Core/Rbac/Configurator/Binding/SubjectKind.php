<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Rbac\Configurator\Binding;

enum SubjectKind
{
    case User;
    case Group;
    case ServiceAccount;
}
