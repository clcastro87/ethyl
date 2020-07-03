<?php

namespace Ethyl\Data;

/**
 * Parametrized Query.
 *
 * @package Ethyl\Data
 */
class Query
{
    /**
     * @var string
     */
    protected $statement;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * Query constructor.
     *
     * @param string $statement
     * @param array $parameters
     */
    public function __construct(string $statement, array $parameters = [])
    {
        $this->statement  = $statement;
        $this->parameters = $parameters;
    }

    /**
     * Gets the query statement.
     *
     * @return string
     */
    public function getStatement(): string
    {
        return $this->statement;
    }

    /**
     * Get query parameters
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}