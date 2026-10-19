<?php

namespace Ethyl\Tests\Pipeline;

use Ethyl\Input\ArrayInput;
use Ethyl\Pipeline\Input;
use Ethyl\Tests\AbstractTestCase;

/**
 * Input Test
 *
 * @package Ethyl\Tests\Pipeline
 */
class InputTest extends AbstractTestCase
{
    /**
     * Tests the extract feature.
     */
    public function testExtract()
    {
        $input = $this->getInput();

        $this->assertEquals([1, 2, 3], iterator_to_array($input->extract([1, 2, 3]), false));
    }

    /**
     * Tests the invoke feature.
     */
    public function testInvoke()
    {
        $input = $this->getInput();

        $this->assertEquals([1, 2, 3], iterator_to_array($input([1, 2, 3]), false));
    }

    /**
     * Returns the pipeline input.
     *
     * @return Input
     */
    protected function getInput(): Input
    {
        return new Input(new ArrayInput());
    }
}
