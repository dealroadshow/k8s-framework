<?php

namespace Dealroadshow\K8S\Framework\App;

interface GroupAwareAppInterface
{
    public function belongsToGroup(string $group): bool;
}
