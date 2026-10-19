<?php

namespace Ethyl\Tests\Mapping;

use ArrayIterator;
use Ethyl\Mapping\MappingIterator;
use Ethyl\Tests\AbstractTestCase;

/**
 * MappingIterator Test
 *
 * @package Ethyl\Tests\Mapping
 */
class MappingIteratorTest extends AbstractTestCase
{
    /**
     * Tests mapping values with a callable.
     */
    public function testMappingIterator()
    {
        $iterator = new MappingIterator(new ArrayIterator(['a' => 1, 'b' => 2]), function ($value, $key) {
            return $key . ':' . $value;
        });

        $this->assertEquals(['a:1', 'b:2'], iterator_to_array($iterator, false));
    }
}
