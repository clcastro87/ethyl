<?php

declare(strict_types=1);

namespace Ethyl\Data;

use EmptyIterator;
use Iterator;
use IteratorIterator;
use PDO;
use PDOStatement;

/**
 * PDO Db wrapper class.
 *
 * @package Ethyl\Data
 */
class Db
{
    /**
     * Default timeout for queries.
     */
    public const DEFAULT_TIMEOUT = 60; // 60 seconds top.

    /**
     * Default options.
     */
    public const DEFAULT_OPTIONS = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT            => self::DEFAULT_TIMEOUT,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    /**
     * @var PDO
     */
    protected $db;

    /**
     * Db constructor.
     *
     * @param PDO $connection
     * @param array $options
     */
    public function __construct(PDO $connection, array $options = [])
    {
        $this->db = $connection;
        $initOpts = $options + self::DEFAULT_OPTIONS;
        $this->setupOptions($initOpts);
    }

    /**
     * Executes a parametrized query and return results.
     *
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function execute(string $query, array $params = []): bool
    {
        $statement = $this->db->prepare($query);

        return $statement->execute($params);
    }

    /**
     * Begins a new transaction.
     *
     * @return bool
     */
    public function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }

    /**
     * Commits the current transaction.
     *
     * @return bool
     */
    public function commit(): bool
    {
        return $this->db->commit();
    }

    /**
     * Rollback the current transaction.
     *
     * @return bool
     */
    public function rollback(): bool
    {
        return $this->db->rollBack();
    }

    /**
     * Runs a query and returns result
     *
     * @param string $query
     * @param array $params
     * @return bool|PDOStatement
     */
    public function query(string $query, array $params = [])
    {
        $statement = $this->db->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    /**
     * Returns an associative array from a query executed.
     *
     * @param string $query
     * @param array $params
     * @return Iterator
     */
    public function getResult(string $query, array $params = []): Iterator
    {
        $dbResult = $this->query($query, $params);

        if (!$dbResult) {
            return new EmptyIterator();
        } else {
            return new IteratorIterator($dbResult);
        }
    }

    /**
     * Setup options to the PDO object
     *
     * @param array $options
     */
    protected function setupOptions(array $options)
    {
        foreach ($options as $option => $value) {
            $this->db->setAttribute($option, $value);
        }
    }
}
