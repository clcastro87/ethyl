<?php

namespace Ethyl\Output;

use League\Csv\Writer;

/**
 * CSV file output.
 * 
 * @package Ethyl\Output
 */
class CsvFileOutput extends CsvOutput
{
    /**
     * CsvStreamOutput constructor.
     * 
     * @param string $filePath
     * @param string $delimiter
     * @param string $openMode
     */
    public function __construct(string $filePath, string $delimiter = self::CSV_DELIMITER_COMMA, string $openMode = 'w+')
    {
        parent::__construct(Writer::createFromPath($filePath, $openMode), $delimiter);
    }
}