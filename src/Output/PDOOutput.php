<?php

namespace Ethyl\Output;

use Ethyl\Core\IteratorStage;
use Exception;
use Iterator;
use PDO;

/**
 * Class PDOOutput
 * @package Ethyl\Output
 */
abstract class PDOOutput extends IteratorStage
{
    /**
     * Max items per transaction
     */
    const MAX_ITEMS = 1000;

    /**
     * Database connection
     *
     * @var PDO
     */
    protected $connection;

    /**
     * Table name
     *
     * @var string
     */
    protected $table;

    /**
     * PDO Output constructor
     *
     * @param string $table
     * @param string $dsn
     * @param string $user
     * @param string $password
     */
    public function __construct(string $table, string $dsn, string $user = '', string $password = '')
    {
        $this->connection = new PDO($dsn, $user, $password);
        $this->table = $table;
    }

    /**
     * {@inheritdoc
     */
    public function iterate(Iterator $iterator)
    {
        $batch = [];
        $count = 0;
        foreach ($iterator as $item)
        {
            $batch[] = $item;
            if (++$count % self::MAX_ITEMS == 0) {
                $this->insertBatch($batch);
                $batch = [];
            }
        }
        if (!empty($batch)) {
            $this->insertBatch($batch);
        }
    }

    /**
     * Writes a header to the output stream
     *
     * @param array $batch
     * @return void
     */
    public function insertBatch(array $batch)
    {
        if (empty($batch)) {
            return;
        }

        $this->connection->beginTransaction();
        $fieldNames = ['id', 'title'];//array_keys($batch[0]);
        $paramNames = array_map(function($value) {
            return ':' . $value;
        }, $fieldNames);

        try {
            $query = sprintf('INSERT INTO %s (%s) VALUES (%s);', $this->table, implode(', ', $fieldNames), implode(', ', $paramNames));
            echo $query . "\n";
            foreach ($batch as $item) {
                $statement = $this->connection->prepare($query);
                $pp = [
                    'id' => $item['id'],
                    'title' => $item['title'] ?? '',
                ];
                $statement->execute($pp);
            }
            $this->connection->commit();
        } catch (Exception $ex) {
            var_dump($ex);
            $this->connection->rollBack();
        }
    }
}