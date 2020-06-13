<?php


namespace Ethyl\Tests\Filter;

use Ethyl\Filter\FunctionIteratorFilter;

/**
 * FunctionIteratorFilter Test
 * @package Ethyl\Tests\Filter
 */
class FunctionIteratorFilterTest extends IteratorFilterTest
{
    /**
     * {@inheritDoc}
     */
    public function getFilter()
    {
        return new FunctionIteratorFilter(function ($item) {
            return $item % 2 == 0;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Even numbers' => [range(0, 10), [0, 2, 4, 6, 8, 10]],
        ];
    }

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public function getFilterTestData()
    {
        return [
            'Even number' => [2, true],
            'Odd number' => [1, false],
        ];
    }
}