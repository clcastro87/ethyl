<?php

namespace Ethyl\Tests\Input;

use Ethyl\Input\CsvFileInput;
use Ethyl\Input\CsvStreamInput;
use Ethyl\Input\FlySystemInput;
use Ethyl\Tests\AbstractTestCase;
use Exception;
use InvalidArgumentException;
use League\Flysystem\Adapter\Local;

/**
 * CsvStreamInput Test
 *
 * @package Ethyl\Tests\Input
 */
class FlySystemInputTest extends AbstractTestCase
{
    /**
     * Tests the CsvStreamInput specifying a file stream.
     *
     * @throws Exception
     */
    public function testInputFilePath()
    {
        $adapter     = new Local('/');
        $streamInput = new FlySystemInput($adapter);
        $input       = new CsvStreamInput(CsvFileInput::CSV_DELIMITER_COMMA);
        $iterator    = $input($streamInput($this->getFilePath()));
        $data        = iterator_to_array($iterator);
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the CsvFileInput specifying an array.
     *
     * @throws Exception
     */
    public function testInputInvalidInput()
    {
        $adapter     = new Local('/');
        $streamInput = new FlySystemInput($adapter);
        $this->expectException(InvalidArgumentException::class);
        $streamInput([$this->getFilePath()]);
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
