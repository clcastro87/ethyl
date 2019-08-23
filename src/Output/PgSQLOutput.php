<?php

namespace Ethyl\Output;

/**
 * Class PgSQLOutput
 * @package Ethyl\Output
 */
class PgSQLOutput extends PDOOutput
{
    /**
     * PostgreSQL Output constructor
     *
     * @param string $table
     * @param string $dsn
     * @param string $user
     * @param string $password
     */
    public function __construct(string $database, string $table, string $host = 'localhost', int $port = 5432, string $user = 'postgres', string $password = '')
    {
        $params = [
            'dbname' => $database,
            'host' => $host,
            'port' => $port,
            'user' => $user,
            'password' => $password,
        ];
        $dsn = implode(';', array_map(
            function ($v, $k) { return sprintf("%s=%s", $k, $v); },
            $params,
            array_keys($params)
        ));
        $dsn = sprintf('pgsql:%s', $dsn);
        parent::__construct($table, $dsn, $user, $password);
    }
}