<?php

namespace Ethyl\Output;

use League\Csv\Writer;

/**
 * Class CsvStreamOutput
 * @package Ethyl\Output
 */
class CsvStreamOutput extends CsvOutput
{
    /**
     * CsvStreamOutput constructor.
     * @param resource $stream
     * @param string $delimiter
     */
    public function __construct($stream, string $delimiter = self::CSV_DELIMITER_COMMA)
    {
        parent::__construct(Writer::createFromStream($stream), $delimiter);
    }
}