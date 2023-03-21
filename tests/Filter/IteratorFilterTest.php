<?php

namespace Ethyl\Tests\Filter;

use ArrayIterator;
use Ethyl\Filter\FilterInterface;
use Ethyl\Filter\FilterIterator;
use Ethyl\Filter\FunctionFilter;
use Ethyl\Filter\IteratorFilter;
use Ethyl\Tests\AbstractTestCase;

/**
 * IteratorFilter Test
 *
 * @package Ethyl\Tests\Filter
 */
class IteratorFilterTest extends AbstractTestCase
{
    /**
     * Test filter feature.
     *
     * @dataProvider getTestData
     * @param $input
     * @param $result
     */
    public function testFilter($input, $result)
    {
        $iteratorFilter = $this->getIteratorFilter();
        $output         = $iteratorFilter($input);

        $this->assertEquals($result, iterator_to_array($output, false));
    }

    /**
     * Test invoke feature.
     *
     * @dataProvider getTestData
     * @param $input
     * @param $result
     */
    public function testInvoke($input, $result)
    {
        $iteratorFilter = $this->getIteratorFilter();
        $output         = $iteratorFilter->iterate(new ArrayIterator($input));

        $this->assertEquals($result, iterator_to_array($output, false));
    }

    /**
     * Test debug feature.
     */
    public function testDebug()
    {
        $filter    = $this->getIteratorFilter();
        $debugInfo = $filter->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the filter to test.
     *
     * @return FilterInterface
     */
    public function getFilter(): FilterInterface
    {
        return new FunctionFilter(function ($item) {
            return $item % 2 == 0;
        });
    }

    /**
     * Returns the iterator filter.
     *
     * @return IteratorFilter
     */
    public function getIteratorFilter(): IteratorFilter
    {
        return new IteratorFilter($this->getFilter());
    }

    /**
     * Get test data.
     */
    public function getTestData(): array
    {
        return [
            'Even numbers' => [range(0, 10), [0, 2, 4, 6, 8, 10]],
            'Empty'        => [[], []],
        ];
    }
}
