<?php

declare(strict_types=1);

namespace Ethyl\Data;

use PDO;
use ReflectionClass;
use ReflectionException;

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
     * @param array $arguments
     * @param array $options
     * @return Db
     * @throws ReflectionException
     */
    public function create(string $dsn, array $arguments = [], array $options = []): Db
    {
        /**
         * @var PDO $pdoConn
         */
        $reflector = new ReflectionClass(PDO::class);
        $pdoConn   = $reflector->newInstanceArgs(array_merge([$dsn], $arguments));

        return new Db($pdoConn, $options);
    }
}
