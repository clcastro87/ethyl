<?php

namespace Ethyl\Tests\Mapping;

use Ethyl\Mapping\MapperInterface;
use Ethyl\Tests\AbstractTestCase;

/**
 * Abstract mapper test.
 *
 * @package Ethyl\Tests\Mapping
 */
abstract class AbstractMapperTest extends AbstractTestCase
{
    /**
     * Test transform feature.
     *
     * @dataProvider getTestData
     * @param $input
     * @param $result
     */
    public function testTransform($input, $result)
    {
        $mapper = $this->getMapper();
        $output = $mapper->map($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Test map feature.
     *
     * @dataProvider getTestData
     * @param $input
     * @param $result
     */
    public function testMap($input, $result)
    {
        $mapper = $this->getMapper();
        $output = $mapper->map($input);

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
        $mapper = $this->getMapper();
        $output = $mapper($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Test debug feature.
     */
    public function testDebug()
    {
        $mapper    = $this->getMapper();
        $debugInfo = $mapper->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the mapper to test.
     *
     * @return MapperInterface
     */
    protected abstract function getMapper(): MapperInterface;

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public abstract function getTestData(): array;
}