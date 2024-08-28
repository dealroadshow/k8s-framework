<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Authentication;

enum WellKnownUserOrGroup: string
{
    case SystemPrivilegedGroup = "system:masters";
    case NodesGroup = "system:nodes";
    case MonitoringGroup = "system:monitoring";
    case AllUnauthenticated = "system:unauthenticated";
    case AllAuthenticated = "system:authenticated";
    case Anonymous = "system:anonymous";
    case APIServerUser = "system:apiserver";

    // core kubernetes process identities
    case KubeProxy = "system:kube-proxy";
    case KubeControllerManager = "system:kube-controller-manager";
    case KubeScheduler = "system:kube-scheduler";

    /**
     * CredentialIDKey is the key used in a user's "extra" to specify the unique
     * identifier for this identity document.
     */
    case CredentialIDKey = "authentication.kubernetes.io/credential-id";
}
