<?php

namespace Ethyl\Tests\Output;

use Ethyl\Output\CsvStreamOutput;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;
use stdClass;

/**
 * CsvStreamOutput Test
 *
 * @package Ethyl\Tests\Output
 */
class CsvStreamOutputTest extends AbstractTestCase
{
    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInput()
    {
        $stream = fopen('php://temp', 'w');
        $input  = new CsvStreamOutput($stream, CsvStreamOutput::CSV_DELIMITER_COMMA);
        $input([
                   [
                       'id'   => 1,
                       'name' => 'Test 1',
                   ],
                   [
                       'id'   => 2,
                       'name' => 'Test 2',
                   ]
               ]);

        $this->assertNotEmpty($stream);
    }

    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInputNotDrain()
    {
        $stream   = fopen('php://temp', 'w');
        $input    = new CsvStreamOutput($stream, CsvStreamOutput::CSV_DELIMITER_COMMA, false);
        $iterator = $input([
                               [
                                   'id'   => 1,
                                   'name' => 'Test 1',
                               ],
                               [
                                   'id'   => 2,
                                   'name' => 'Test 2',
                               ]
                           ]);

        $this->assertNotEmpty($stream);
        $count = iterator_count($iterator);
        $this->assertEquals(2, $count);
    }

    /**
     * Tests empty input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayEmptyInput()
    {
        $stream = fopen('php://temp', 'w');
        $input  = new CsvStreamOutput($stream);
        $input([]);

        $this->assertNotEmpty($stream);
    }

    /**
     * Tests invalid input.
     *
     * @throws InvalidArgumentException
     */
    public function testInvalidInput()
    {
        $stream = fopen('php://temp', 'w');
        $input  = new CsvStreamOutput($stream);
        $this->expectException(InvalidArgumentException::class);
        $input(new stdClass());
    }
}
