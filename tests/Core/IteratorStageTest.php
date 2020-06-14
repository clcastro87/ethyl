<?php


namespace Ethyl\Tests\Core;

use ArrayIterator;
use Ethyl\Core\IteratorStage;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;
use Iterator;

/**
 * IteratorStage Test
 * @package Ethyl\Tests\Core
 */
class IteratorStageTest extends AbstractTestCase
{
    /**
     * Test filter feature.
     *
     * @dataProvider getIteratorData
     * @param $input
     * @param $result
     */
    public function testIterate($input, $result)
    {
        $stage = $this->getIteratorStage();
        $output = $this->convertToArray($stage($input));

        $this->assertEquals($result, $output);
    }

    /**
     * Test invoke feature.
     *
     * @dataProvider getTestData
     * @param $input
     * @param $result
     * @param bool $exception
     */
    public function testInvoke($input, $result, $exception = null)
    {
        $stage = $this->getIteratorStage();
        if (!empty($exception)) {
            $this->expectException($exception);
            $output = $this->convertToArray($stage($input));
        } else {
            $output = $this->convertToArray($stage($input));
            $this->assertEquals($result, $output);
        }
    }

    /**
     * Converts an iterator to array.
     *
     * @param Iterator $iterator
     * @return array
     */
    protected function convertToArray(Iterator $iterator)
    {
        return iterator_to_array($iterator);
    }

    /**
     * Test debug feature.
     */
    public function testDebug()
    {
        $filter = $this->getIteratorStage();
        $debugInfo = $filter->debug();

        $this->assertNotEmpty($debugInfo);
    }

    /**
     * Gets the IteratorStage to test.
     *
     * @return IteratorStage
     */
    public function getIteratorStage()
    {
        return new TestIteratorStage();
    }

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public function getTestData()
    {
        return [
            'Array' => [range(0, 10), range(0, 10)],
            'Iterator' => [new ArrayIterator(range(0, 10)), range(0, 10)],
            'Wrong Input' => ['test', '', InvalidArgumentException::class],
        ];
    }

    /**
     * Function to provide test cases.
     *
     * @return array
     */
    public function getIteratorData()
    {
        return [
            'Iterator' => [new ArrayIterator(range(0, 10)), range(0, 10)],
        ];
    }
}