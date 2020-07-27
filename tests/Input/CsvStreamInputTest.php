<?php

namespace Ethyl\Tests\Input;

use Ethyl\Input\CsvFileInput;
use Ethyl\Input\CsvStreamInput;
use Ethyl\Tests\AbstractTestCase;
use Exception;
use InvalidArgumentException;

/**
 * CsvStreamInput Test
 *
 * @package Ethyl\Tests\Input
 */
class CsvStreamInputTest extends AbstractTestCase
{
    /**
     * Tests the CsvStreamInput specifying a file stream.
     *
     * @throws Exception
     */
    public function testInputFileStream()
    {
        $input    = new CsvStreamInput(CsvFileInput::CSV_DELIMITER_COMMA);
        $iterator = $input($this->getFileStream());
        $data     = iterator_to_array($iterator);
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the CsvFileInput specifying an array.
     *
     * @throws Exception
     */
    public function testInputInvalidInput()
    {
        $input = new CsvStreamInput(CsvFileInput::CSV_DELIMITER_COMMA);
        $this->expectException(InvalidArgumentException::class);
        $input([$this->getFileStream()]);
    }

    /**
     * Returns the test file stream.
     *
     * @return string
     */
    protected function getFileStream()
    {
        $path = __DIR__ . '/../Resources/sales.csv';

        return fopen($path, 'r');
    }
}