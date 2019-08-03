<?php

namespace Ethyl\Input;

/**
 * Class TsvFileInput
 * @package Ethyl\Input
 */
class TsvFileInput extends CsvFileInput
{
    /**
     * TsvFileInput constructor.
     * @param string $delimiter
     */
    public function __construct(string $delimiter = self::CSV_DELIMITER_TAB)
    {
        parent::__construct($delimiter);
    }
}