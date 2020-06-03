<?php

namespace Ethyl\Data;

use PDO;
use ReflectionClass;
use ReflectionException;

/**
 * PDO Db Factory Class
 */
final class DbFactory
{
    /**
     * Creates an instance of a Db object
     *
     * @param string $dsn
     * @param array  $arguments
     * @param array  $options
     * @return Db
     * @throws ReflectionException
     */
    public function create(string $dsn, array $arguments = [], array $options = [])
    {
        /**
         * @var PDO $pdoConn
         */
        $reflector = new ReflectionClass(PDO::class);
        $pdoConn   = $reflector->newInstanceArgs(array_merge([$dsn], $arguments));
        $db        = new Db($pdoConn, $options);

        return $db;
    }
}