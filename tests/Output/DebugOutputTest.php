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
        ob_start();
        $iterator = $input([1, 2, 3]);
        ob_get_clean();

        $count = iterator_count($iterator);
        $this->assertEquals(3, $count);
    }

    /**
     * Tests array input drain.
     *
     * @throws InvalidArgumentException
     */
    public function testArrayDrainInput()
    {
        $input = new DebugOutput();
        ob_start();
        $iterator = $input([1, 2, 3]);
        ob_get_clean();

        $count = iterator_count($iterator);
        $this->assertEquals(0, $count);
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