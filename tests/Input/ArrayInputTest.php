<?php

namespace Ethyl\Tests\Input;

use Ethyl\Input\ArrayInput;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;
use stdClass;

/**
 * ArrayInput Test
 *
 * @package Ethyl\Tests\Input
 */
class ArrayInputTest extends AbstractTestCase
{
    /**
     * Tests array input
     *
     * @throws InvalidArgumentException
     */
    public function testArrayInput()
    {
        $input    = new ArrayInput();
        $iterator = $input([1, 2, 3]);

        $count = iterator_count($iterator);
        $this->assertEquals(3, $count);
    }

    /**
     * Tests array input
     *
     * @throws InvalidArgumentException
     */
    public function testArrayWrongInput()
    {
        $input = new ArrayInput();
        $this->expectException(InvalidArgumentException::class);
        $input(new stdClass());
    }
}