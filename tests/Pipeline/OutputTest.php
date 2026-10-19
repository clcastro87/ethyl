<?php

namespace Ethyl\Tests\Pipeline;

use ArrayIterator;
use Ethyl\Core\FunctionStage;
use Ethyl\Pipeline\Output;
use Ethyl\Tests\AbstractTestCase;

/**
 * Output Test
 *
 * @package Ethyl\Tests\Pipeline
 */
class OutputTest extends AbstractTestCase
{
    /**
     * Tests the load feature.
     */
    public function testLoad()
    {
        $loaded = null;
        $output = new Output(new FunctionStage(function ($iterator) use (&$loaded) {
            $loaded = iterator_to_array($iterator, false);

            return $iterator;
        }));

        $output->load(new ArrayIterator([1, 2, 3]));

        $this->assertEquals([1, 2, 3], $loaded);
    }

    /**
     * Tests the load feature with a format processor.
     */
    public function testLoadWithFormatProcessor()
    {
        $loaded = null;
        $output = new Output(
            new FunctionStage(function ($iterator) use (&$loaded) {
                $loaded = iterator_to_array($iterator, false);

                return $iterator;
            }),
            new FunctionStage(function () {
                return new ArrayIterator([4, 5, 6]);
            })
        );

        $output->load(new ArrayIterator([1, 2, 3]));

        $this->assertEquals([4, 5, 6], $loaded);
    }

    /**
     * Tests the invoke feature.
     */
    public function testInvoke()
    {
        $loaded = null;
        $output = new Output(new FunctionStage(function ($iterator) use (&$loaded) {
            $loaded = iterator_to_array($iterator, false);

            return $iterator;
        }));

        $output(new ArrayIterator([1, 2, 3]));

        $this->assertEquals([1, 2, 3], $loaded);
    }
}
