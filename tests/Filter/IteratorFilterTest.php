<?php


namespace Ethyl\Tests\Filter;


use Ethyl\Filter\FilterInterface;
use Ethyl\Tests\AbstractTestCase;

/**
 * IteratorFilter Test
 * @package Ethyl\Tests\Filter
 */
abstract class IteratorFilterTest extends AbstractTestCase
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
        $output = $filter->satisfy($input);

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
        $output = iterator_to_array($filter($input));

        $this->assertEquals($result, $output);
    }

    /**
     * Test debug feature.
     */
    public function testDebug()
    {
        $filter = $this->getFilter();
        $debugInfo = $filter->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the filter to test.
     *
     * @return FilterInterface
     */
    public abstract function getFilter();

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public abstract function getTestData();

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public abstract function getFilterTestData();
}