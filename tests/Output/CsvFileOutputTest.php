<?php


namespace Ethyl\Tests\Output;

use Ethyl\Output\CsvFileOutput;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;
use stdClass;

/**
 * CsvFileOutput Test
 *
 * @package Ethyl\Tests\Output
 */
class CsvFileOutputTest extends AbstractTestCase
{
    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInput()
    {
        $tmpFilePath = $this->getTempFilePath();

        $input = new CsvFileOutput($tmpFilePath, CsvFileOutput::CSV_DELIMITER_COMMA);
        $input([
            [
                'id' => 1,
                'name' => 'Test 1',
            ],
            [
                'id' => 2,
                'name' => 'Test 2',
            ]
        ]);

        $this->assertNotEmpty(file_get_contents($tmpFilePath));

        unlink($tmpFilePath);
    }

    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInputNotDrain()
    {
        $tmpFilePath = $this->getTempFilePath();

        $input = new CsvFileOutput($tmpFilePath, CsvFileOutput::CSV_DELIMITER_COMMA, 'w+',false);
        $iterator = $input([
            [
                'id' => 1,
                'name' => 'Test 1',
            ],
            [
                'id' => 2,
                'name' => 'Test 2',
            ]
        ]);

        $count = iterator_count($iterator);
        $this->assertEquals(2, $count);
        $this->assertNotEmpty(file_get_contents($tmpFilePath));

        unlink($tmpFilePath);
    }

    /**
     * Tests empty input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayEmptyInput()
    {
        $tmpFilePath = $this->getTempFilePath();

        $input = new CsvFileOutput($tmpFilePath);
        $input([]);

        $this->assertEmpty(file_get_contents($tmpFilePath));

        unlink($tmpFilePath);
    }

    /**
     * Tests invalid input.
     *
     * @throws InvalidArgumentException
     */
    public function testInvalidInput()
    {
        $tmpFilePath = $this->getTempFilePath();

        try {
            $input = new CsvFileOutput($tmpFilePath);
            $this->expectException(InvalidArgumentException::class);
            $input(new stdClass());
        } finally {
            unlink($tmpFilePath);
        }
    }

    /**
     * Returns a file name for a temp csv file.
     *
     * @return string
     */
    private function getTempFilePath()
    {
        return tempnam("/tmp", "TEST");
    }
}