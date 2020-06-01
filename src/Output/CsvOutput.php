<?php

namespace Ethyl\Output;

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
     */
    public function __construct(Writer $writer, string $delimiter = self::CSV_DELIMITER_COMMA)
    {
        $this->delimiter = $delimiter;
        $this->writer    = $writer;
    }

    /**
     * {@inheritdoc}
     * @throws CsvException
     */
    public function writeHeader($item)
    {
        $this->writer->setDelimiter($this->delimiter);
        $this->writer->insertOne(array_keys($item));
    }

    /**
     * {@inheritdoc}
     * @throws CannotInsertRecord
     */
    public function writeItem($item)
    {
        $this->writer->insertOne($item);
    }
}