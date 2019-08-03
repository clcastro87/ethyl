<?php

namespace Ethyl\Input;

use Iterator;
use League\Csv\Reader;

/**
 * Class CsvStreamInput
 * @package Ethyl\Input
 */
class CsvStreamInput extends StreamInput
{
    const CSV_DELIMITER_COMMA = ',';
    const CSV_DELIMITER_SEMICOLON = ';';
    const CSV_DELIMITER_TAB = "\t";

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * CsvStreamInput constructor.
     * @param string $delimiter
     */
    public function __construct(string $delimiter = self::CSV_DELIMITER_COMMA)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Returns an iterator for accessing to the stream input
     *
     * @param $payload
     * @return Iterator
     * @throws \League\Csv\Exception
     */
    public function getIterator($payload)
    {
        $reader = Reader::createFromStream($payload);
        $reader->setDelimiter($this->delimiter)
               ->setHeaderOffset(0);

        return $reader->getRecords();
    }
}