<?php

namespace Ethyl\Tests\Transform;

use Ethyl\Tests\AbstractTestCase;
use Ethyl\Transform\TransformerInterface;

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
     */
    public function testDebug()
    {
        $transformer = $this->getTransformer();
        $debugInfo   = $transformer->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the transform to test.
     *
     * @return TransformerInterface
     */
    public abstract function getTransformer(): TransformerInterface;

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public abstract function getTestData(): array;
}