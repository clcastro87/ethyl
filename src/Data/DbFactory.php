<?php

namespace Ethyl\Data;

use PDO;
use ReflectionClass;

/**
 * PDO Db Factory Class.
 *
 * @package Ethyl\Data
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
     */
    public function create(string $dsn, array $arguments = [], array $options = [])
    {
        /**
         * @var PDO $pdoConn
         */
        $reflector = new ReflectionClass(PDO::class);
        $pdoConn   = $reflector->newInstanceArgs(array_merge([$dsn], $arguments));

        return new Db($pdoConn, $options);
    }
}