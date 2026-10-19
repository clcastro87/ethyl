<?php

namespace Ethyl\Tests\Helper;

use ArrayIterator;
use ArrayObject;
use EmptyIterator;
use Ethyl\Helper\IteratorTools;
use Ethyl\Tests\AbstractTestCase;

/**
 * IteratorTools Test
 *
 * @package Ethyl\Tests\Helper
 */
class IteratorToolsTest extends AbstractTestCase
{
    /**
     * Tests converting an array.
     */
    public function testConvertArray()
    {
        $iterator = IteratorTools::convertToIterator([1, 2, 3]);

        $this->assertInstanceOf(ArrayIterator::class, $iterator);
        $this->assertEquals([1, 2, 3], iterator_to_array($iterator));
    }

    /**
     * Tests converting an empty array.
     */
    public function testConvertEmptyArray()
    {
        $iterator = IteratorTools::convertToIterator([]);

        $this->assertInstanceOf(EmptyIterator::class, $iterator);
        $this->assertEquals([], iterator_to_array($iterator));
    }

    /**
     * Tests converting an iterator aggregate.
     */
    public function testConvertIteratorAggregate()
    {
        $iterator = IteratorTools::convertToIterator(new ArrayObject([1, 2, 3]));

        $this->assertInstanceOf(ArrayIterator::class, $iterator);
        $this->assertEquals([1, 2, 3], iterator_to_array($iterator));
    }

    /**
     * Tests converting an iterator.
     */
    public function testConvertIterator()
    {
        $source = new ArrayIterator([1, 2, 3]);

        $this->assertSame($source, IteratorTools::convertToIterator($source));
    }
}
