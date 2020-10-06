<?php

namespace Dealroadshow\K8S\Framework\Core\Container\Lifecycle\Action;

use Dealroadshow\K8S\Data\HTTPGetAction;
use Dealroadshow\K8S\Data\TCPSocketAction;
use Dealroadshow\K8S\ValueObject\IntOrString;

trait ActionConfiguratorTrait
{
    public function exec(array $command): void
    {
        $command = array_values($command);

        $action = $this->handler->exec();
        $action->command()->addAll($command);
    }

    /**
     * @param int|string $port
     *
     * @return HttpGetActionBuilder
     */
    public function httpGet($port): HttpGetActionBuilder
    {
        $action = new HTTPGetAction($this->getPort($port));
        $this->handler->setHttpGet($action);

        return new HttpGetActionBuilder($action);
    }

    public function tcpSocket($port, string $host = null): void
    {
        $action = new TCPSocketAction($this->getPort($port));
        if (null !== $host) {
            $action->setHost($host);
        }

        $this->handler->setTcpSocket($action);
    }

    /**
     * @param int|string $port
     *
     * @return IntOrString
     */
    private function getPort($port): IntOrString
    {
        if (is_string($port)) {
            return IntOrString::fromString($port);
        }
        if (is_int($port)) {
            return IntOrString::fromInt($port);
        }

        throw new \TypeError('$port must be an int or a string');
    }
}
