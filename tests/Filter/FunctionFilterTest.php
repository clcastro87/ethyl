<?php

namespace Ethyl\Tests\Filter;

use Ethyl\Filter\FilterInterface;
use Ethyl\Filter\FunctionFilter;

/**
 * FunctionFilter Test
 *
 * @package Ethyl\Tests\Filter
 */
class FunctionFilterTest extends ValueFilterTest
{
    /**
     * {@inheritDoc}
     */
    public function getFilter(): FilterInterface
    {
        return new FunctionFilter(function ($item) {
            return $item % 2 == 0;
        });
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData(): array
    {
        return [
            'Even number' => [2, true],
            'Odd number'  => [1, false],
        ];
    }

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public function getFilterTestData(): array
    {
        return [
            'Even number' => [2, true],
            'Odd number'  => [1, false],
        ];
    }
}