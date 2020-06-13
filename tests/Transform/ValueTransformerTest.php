<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Tests\AbstractTestCase;

/**
 * Value transformer test.
 */
abstract class ValueTransformerTest extends AbstractTestCase
{
    /**
     * Test transform feature.
     *
     * @dataProvider getTestData
     * @param $input
     * @param $result
     */
    public function testTransformer($input, $result)
    {
        $transformer = $this->getTransformer();
        $output      = $transformer->transform($input);

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
        $transformer = $this->getTransformer();
        $output      = $transformer($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Test debug feature.
     * 
     * @dataProvider getTestData
     */
    public function testDebug()
    {
        $transformer = $this->getTransformer();
        $debugInfo   = $transformer->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the transform to test.
     */
    public abstract function getTransformer();

    /**
     * Function to provide test cases.
     * 
     * @dataProvider
     */
    public abstract function getTestData();
}