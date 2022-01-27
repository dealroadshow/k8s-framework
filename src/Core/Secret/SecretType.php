<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

enum SecretType: string
{
    case Opaque = 'Opaque';
    case ServiceAccountToken = 'kubernetes.io/service-account-token';
    case DockerConfig = 'kubernetes.io/dockerconfigjson';
    case BasicAuth = 'kubernetes.io/basic-auth';
    case SshAuth = 'kubernetes.io/ssh-auth';
    case TLS = 'kubernetes.io/tls';
}
