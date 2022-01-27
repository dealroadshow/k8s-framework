<?php

declare(strict_types=1);

namespace Dealroadshow\K8S\Framework\Core\Secret;

use Dealroadshow\K8S\Data\Collection\StringMap;
use InvalidArgumentException;

abstract class AbstractDockerConfigSecret extends AbstractSecret
{
    private const DATA_KEY = '.dockerconfigjson';

    /**
     * @return DockerAuth[]
     */
    abstract protected function auths(): iterable;

    final public function data(StringMap $data): void
    {
        $authsList = [];
        foreach ($this->auths() as $auth) {
            if (!$auth instanceof DockerAuth) {
                $type = gettype($auth);
                throw new InvalidArgumentException(
                    sprintf(
                        'Method authsList() must return array of %s instances, got "%s"',
                        DockerAuth::class,
                        'object' === $type ? $auth::class : $type
                    )
                );
            }

            $authsList[$auth->host] = [
                'username' => $auth->username,
                'password' => $auth->password,
                'auth' => base64_encode($auth->username.':'.$auth->password),
            ];

            if (null !== $auth->email) {
                $authsList[$auth->host]['email'] = $auth->email;
            }
        }

        $dockerConfig = ['auths' => $authsList];
        $data->add(self::DATA_KEY, json_encode($dockerConfig));
    }

    final public function stringData(StringMap $stringData): void
    {
    }

    final public function type(): SecretType
    {
        return SecretType::DockerConfig;
    }
}
