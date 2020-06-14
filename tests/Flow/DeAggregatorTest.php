<?php


namespace Ethyl\Tests\Flow;

use Ethyl\Flow\BatchAggregator;
use Ethyl\Flow\DeAggregator;
use Ethyl\Tests\Core\IteratorStageTest;

/**
 * Class DeAggregatorTest
 * @package Ethyl\Tests\Flow
 */
class DeAggregatorTest extends IteratorStageTest
{
    /**
     * {@inheritDoc}
     */
    public function getIteratorStage()
    {
        return new DeAggregator();
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Array' => [[[0,1,2], [3,4,5], [6,7,8], [9,10]], range(0, 10)],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getIteratorData()
    {
        return $this->getTestData();
    }
}