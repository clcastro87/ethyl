<?php

namespace Ethyl\Output;

use League\Csv\Writer;

/**
 * Class CsvOutput
 * @package Ethyl\Output
 */
class CsvOutput extends StreamOutput
{
    const CSV_DELIMITER_COMMA = ',';
    const CSV_DELIMITER_SEMICOLON = ';';
    const CSV_DELIMITER_TAB = "\t";

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
     * @param Writer $writer
     * @param string $delimiter
     */
    public function __construct(Writer $writer, string $delimiter = self::CSV_DELIMITER_COMMA)
    {
        $this->delimiter = $delimiter;
        $this->writer = $writer;
    }

    /**
     * {@inheritdoc}
     * @throws \League\Csv\Exception
     */
    public function writeHeader($item)
    {
        $this->writer->setDelimiter($this->delimiter);
        $this->writer->insertOne(array_keys($item));
    }

    /**
     * {@inheritdoc}
     * @throws \League\Csv\CannotInsertRecord
     */
    public function writeItem($item)
    {
        $this->writer->insertOne($item);
    }
}