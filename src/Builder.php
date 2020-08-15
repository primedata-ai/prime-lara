<?php


namespace Prime;

use Enqueue\Redis\RedisConnectionFactory;
use Interop\Queue\ConnectionFactory;
use Interop\Queue\Exception\Exception;

class Builder
{
    /**
     * @param array $config
     * @return ConnectionFactory
     * @throws Exception
     */
    public function buildConnection(array $config): ConnectionFactory
    {
        if (!array_key_exists('redis', $config)) {
            throw new Exception('Currently we only support redis');
        }
        return $this->buildRedis($config['redis']);
    }

    /**
     * Build Redis Connection factory
     * @param array $config
     * @return RedisConnectionFactory
     */
    private function buildRedis(array $config)
    {
        return new RedisConnectionFactory($config);
    }
}