<?php

declare(strict_types=1);

namespace Ethyl\Input;

use Ethyl\Core\IteratorStage;
use Ethyl\Data\Db;
use Ethyl\Data\Query;
use InvalidArgumentException;
use Iterator;
use PDOStatement;

/**
 * Iterates over the items present on a query result.
 *
 * @package Ethyl\Input
 */
class PdoQueryInput extends IteratorStage
{
    /**
     * @var Db
     */
    protected $db;

    /**
     * PdoQueryInput constructor.
     *
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        parent::__construct();

        $this->db = $db;
    }

    /**
     * @inheritDoc
     */
    public function __invoke($payload): Iterator
    {
        $query = null;
        if (is_a($payload, Query::class)) {
            $query = $payload;
        } else {
            if (is_string($payload)) {
                $query = new Query($payload);
            } else {
                throw new InvalidArgumentException('This stage is only applicable to query or string objects.');
            }
        }

        $pdoStatement = $this->db->query($query->getStatement(), $query->getParameters());
        $iterator     = $this->processStatement($pdoStatement);

        return $this->iterate($iterator);
    }

    /**
     * Processes the statement
     *
     * @param PDOStatement $statement
     * @return Iterator
     */
    protected function processStatement(PDOStatement $statement)
    {
        while ($item = $statement->fetch()) {
            yield $item;
        }

        yield from [];
    }
}
