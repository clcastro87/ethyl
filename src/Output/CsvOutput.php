<?php

declare(strict_types=1);

namespace Ethyl\Output;

use Iterator;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception as CsvException;
use League\Csv\Writer;

/**
 * Abstraction for CSV output using CSV Writer.
 *
 * @package Ethyl\Output
 */
abstract class CsvOutput extends StreamOutput
{
    /**
     * Common delimiters for CSV files.
     */
    const CSV_DELIMITER_COMMA     = ',';
    const CSV_DELIMITER_SEMICOLON = ';';
    const CSV_DELIMITER_TAB       = "\t";

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var Writer
     */
    protected $writer;

    /**
     * CsvStreamOutput constructor.
     *
     * @param Writer $writer
     * @param string $delimiter
     * @param bool $drain
     */
    public function __construct(Writer $writer, string $delimiter = self::CSV_DELIMITER_COMMA, bool $drain = true)
    {
        parent::__construct($drain);

        $this->delimiter = $delimiter;
        $this->writer    = $writer;
    }

    /**
     * @inheritDoc
     * @throws CsvException
     */
    public function writeHeader(Iterator $iterator)
    {
        $this->writer->setDelimiter($this->delimiter);
        if ($iterator->valid() && !empty($iterator->current()) && is_array($iterator->current())) {
            $this->writer->insertOne(array_keys($iterator->current()));
        }
    }

    /**
     * @inheritDoc
     * @throws CannotInsertRecord
     */
    public function writeItem($item)
    {
        $this->writer->insertOne($item);
    }
}
