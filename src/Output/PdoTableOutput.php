<?php

declare(strict_types=1);

namespace Ethyl\Output;

use EmptyIterator;
use Ethyl\Data\Db;
use Exception;
use Iterator;

/**
 * PdoTable Output.
 *
 * @package Ethyl\Output
 */
class PdoTableOutput extends AbstractOutput
{
    /**
     * Batch size.
     */
    const BATCH_SIZE_DEFAULT = 100;

    /**
     * Flags.
     */
    const FLAG_TRANSACTIONAL = 2;
    const FLAG_USE_TEMP      = 4;

    /**
     * @var Db
     */
    protected $connection;

    /**
     * @var bool
     */
    protected $transactional;

    /**
     * @var int
     */
    protected $batchSize;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var bool
     */
    protected $useTempTable;

    /**
     * PdoTableOutput constructor.
     *
     * @param Db $connection
     * @param string $table
     * @param int $batchSize
     * @param int $flags
     * @param bool $drain
     */
    public function __construct(
        Db $connection,
        string $table,
        int $batchSize = self::BATCH_SIZE_DEFAULT,
        int $flags = self::FLAG_TRANSACTIONAL | self::FLAG_USE_TEMP,
        $drain = true
    ) {
        parent::__construct($drain);

        $this->connection    = $connection;
        $this->table         = $table;
        $this->useTempTable  = ($flags & self::FLAG_USE_TEMP) === self::FLAG_USE_TEMP;
        $this->batchSize     = $batchSize;
        $this->transactional = ($flags & self::FLAG_TRANSACTIONAL) === self::FLAG_TRANSACTIONAL;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function iterate(Iterator $iterator): Iterator
    {
        if ($iterator->valid() && !empty($iterator->current())) {
            try {
                if ($this->transactional) {
                    $this->connection->beginTransaction();
                }
                $this->internalIterate($iterator);
                if ($this->transactional) {
                    $this->connection->commit();
                }
            } catch (Exception $ex) {
                if ($this->transactional) {
                    $this->connection->rollback();
                }
                throw $ex;
            }
        }

        if (!$this->drain) {
            $iterator->rewind();
            return $iterator;
        } else {
            return new EmptyIterator();
        }
    }

    /**
     * Iterate inside transaction.
     *
     * @param Iterator $iterator
     */
    protected function internalIterate(Iterator $iterator)
    {
        $first  = $iterator->current();
        $fields = array_keys($first);
        $table  = $this->table; // TODO: Temp table.
        $insert = sprintf('INSERT INTO `%s` (%s) VALUES ', $table, implode(', ', $fields));

        $insertParams = [];
        $bindData     = [];
        $count        = 0;
        foreach ($iterator as $row) {
            $params = [];
            foreach ($row as $columnName => $columnValue) {
                $param            = ":{$columnName}_{$count}";
                $params[]         = $param;
                $bindData[$param] = $columnValue;
            }
            $paramsStr      = implode(', ', $params);
            $insertParams[] = "({$paramsStr})";

            if ((++$count % $this->batchSize) === 0) {
                $this->processBatch($insertParams, $bindData, $insert);
                $insertParams = [];
                $bindData     = [];
            }
        }

        if (!empty($insertParams)) {
            $this->processBatch($insertParams, $bindData, $insert);
        }
    }

    /**
     * Process a batch.
     *
     * @param array $params
     * @param array $values
     * @param string $insert
     */
    protected function processBatch(array $params, array $values, string $insert)
    {
        $fullInsert = $insert . implode(', ', $params) . ';';

        $this->connection->execute($fullInsert, $values);
    }
}
