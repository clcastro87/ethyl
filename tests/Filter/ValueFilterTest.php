<?php

namespace Ethyl\Tests\Filter;

use Ethyl\Filter\FilterInterface;
use Ethyl\Tests\AbstractTestCase;

/**
 * Value Filter Test
 *
 * @package Ethyl\Tests\Filter
 */
abstract class ValueFilterTest extends AbstractTestCase
{
    /**
     * Test filter feature.
     *
     * @dataProvider getFilterTestData
     * @param $input
     * @param $result
     */
    public function testFilter($input, $result)
    {
        $filter = $this->getFilter();
        $output = $filter->accept($input);

        $this->assertEquals($result, $output);
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
        $filter = $this->getFilter();
        $output = $filter($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Test debug feature.
     */
    public function testDebug()
    {
        $filter    = $this->getFilter();
        $debugInfo = $filter->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the filter to test.
     *
     * @return FilterInterface
     */
    abstract public function getFilter(): FilterInterface;

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    abstract public function getTestData(): array;

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    abstract public function getFilterTestData(): array;
}
