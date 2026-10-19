<?php

namespace Ethyl\Tests\Filter;

use ArrayIterator;
use Ethyl\Filter\FilterIterator;
use Ethyl\Tests\AbstractTestCase;

/**
 * FilterIterator Test
 *
 * @package Ethyl\Tests\Filter
 */
class FilterIteratorTest extends AbstractTestCase
{
    /**
     * Tests filtering an iterator using a callable.
     */
    public function testFilter()
    {
        $iterator = new FilterIterator(new ArrayIterator(range(0, 10)), function ($item) {
            return $item % 2 == 0;
        });

        $this->assertEquals([0, 2, 4, 6, 8, 10], iterator_to_array($iterator, false));
    }

    /**
     * Tests the accept feature.
     */
    public function testAccept()
    {
        $acceptFn = function ($item) {
            return $item % 2 == 0;
        };

        $even = new FilterIterator(new ArrayIterator([0]), $acceptFn);
        $odd  = new FilterIterator(new ArrayIterator([1]), $acceptFn);

        $this->assertTrue($even->accept());
        $this->assertFalse($odd->accept());
    }
}
