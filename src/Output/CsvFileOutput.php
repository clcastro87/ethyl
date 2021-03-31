<?php

declare(strict_types=1);

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
     * @param bool $drain
     */
    public function __construct(string $filePath, string $delimiter = self::CSV_DELIMITER_COMMA, string $openMode = 'w+', bool $drain = true)
    {
        parent::__construct(Writer::createFromPath($filePath, $openMode), $delimiter, $drain);
    }
}
