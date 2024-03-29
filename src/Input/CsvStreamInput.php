<?php

declare(strict_types=1);

namespace Ethyl\Input;

use Iterator;
use League\Csv\Reader;
use League\Csv\Exception as CsvException;

/**
 * CSV Stream Input.
 *
 * @package Ethyl\Input
 */
class CsvStreamInput extends StreamInput
{
    /**
     * Common delimiters for CSV files.
     */
    public const CSV_DELIMITER_COMMA     = ',';
    public const CSV_DELIMITER_SEMICOLON = ';';
    public const CSV_DELIMITER_TAB       = "\t";

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * CsvStreamInput constructor.
     *
     * @param string $delimiter
     */
    public function __construct(string $delimiter = self::CSV_DELIMITER_COMMA)
    {
        parent::__construct();

        $this->delimiter = $delimiter;
    }

    /**
     * Returns an iterator for accessing to the stream input
     *
     * @inheritDoc
     * @throws CsvException
     */
    public function getIterator($payload): Iterator
    {
        $reader = Reader::createFromStream($payload);
        $reader->setDelimiter($this->delimiter)
               ->setHeaderOffset(0);

        return $reader->getRecords();
    }
}
