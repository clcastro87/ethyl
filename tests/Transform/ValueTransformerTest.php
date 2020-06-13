<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Tests\AbstractTestCase;
use Ethyl\Transform\ValueTransformer;

/**
 * Value transformer test.
 */
abstract class ValueTransformerTest extends AbstractTestCase
{
    /**
     * Test transform feature.
     * 
     * @dataProvider getTestData
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
     */
    public function testInvoke($input, $result)
    {
        $transformer = $this->getTransformer();
        $output      = $transformer($input);

        $this->assertEquals($result, $output);
    }

    /**
     * Test invoke feature.
     * 
     * @dataProvider getTestData
     */
    public function testJsonSerialize()
    {
        $transformer = $this->getTransformer();
        $jsonValue   = $transformer->jsonSerialize();

        $this->assertNotEmpty($jsonValue);
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