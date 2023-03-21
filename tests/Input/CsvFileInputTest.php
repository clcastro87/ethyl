<?php

namespace Ethyl\Tests\Input;

use Ethyl\Input\CsvFileInput;
use Ethyl\Tests\AbstractTestCase;
use Exception;
use InvalidArgumentException;

/**
 * CsvFileInput Test
 *
 * @package Ethyl\Tests\Input
 */
class CsvFileInputTest extends AbstractTestCase
{
    /**
     * Tests the CsvFileInput specifying a file path.
     *
     * @throws Exception
     */
    public function testInputFilePath()
    {
        $input    = new CsvFileInput(CsvFileInput::CSV_DELIMITER_COMMA);
        $iterator = $input($this->getFilePath());
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
        $input = new CsvFileInput(CsvFileInput::CSV_DELIMITER_COMMA);
        $this->expectException(InvalidArgumentException::class);
        $input([$this->getFilePath()]);
    }

    /**
     * Returns the test file path.
     *
     * @return string
     */
    protected function getFilePath(): string
    {
        return __DIR__ . '/../Resources/sales.csv';
    }
}
