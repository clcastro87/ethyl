<?php


namespace Ethyl\Tests\Output;

use Ethyl\Output\DebugOutput;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;
use stdClass;

/**
 * DebugOutput Test
 *
 * @package Ethyl\Tests\Output
 */
class DebugOutputTest extends AbstractTestCase
{
    /**
     * Tests array input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInput()
    {
        $input = new DebugOutput(false);
        $iterator = $input([1, 2, 3]);

        $count = iterator_count($iterator);
        $this->assertEquals(3, $count);
    }

    /**
     * Tests wrong input.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayWrongInput()
    {
        $input = new DebugOutput();
        $this->expectException(InvalidArgumentException::class);
        $input(new stdClass());
    }
}