<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Action;

use Dealroadshow\K8S\Api\Core\V1\HTTPGetAction;
use Dealroadshow\K8S\Api\Core\V1\TCPSocketAction;

trait ActionConfiguratorTrait
{
    public function exec(array $command): void
    {
        $command = array_values($command);

        $action = $this->handler->exec();
        $action->command()->addAll($command);
    }

    public function httpGet(int|string $port): HttpGetActionBuilder
    {
        $action = new HTTPGetAction($port);
        $this->handler->setHttpGet($action);

        return new HttpGetActionBuilder($action);
    }

    public function tcpSocket(int|string $port, string|null $host = null): void
    {
        $action = new TCPSocketAction($port);
        if (null !== $host) {
            $action->setHost($host);
        }

        $this->handler->setTcpSocket($action);
    }
}
