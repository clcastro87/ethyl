<?php

namespace Ethyl\Tests\Flow;

use Ethyl\Flow\BatchAggregator;
use Ethyl\Tests\Core\IteratorStageTest;

/**
 * BatchAggregator Test
 *
 * @package Ethyl\Tests\Flow
 */
class BatchAggregatorTest extends IteratorStageTest
{
    /**
     * {@inheritDoc}
     */
    public function getIteratorStage()
    {
        return new BatchAggregator(3);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Array' => [range(0, 10), [[0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10]]],
            'Empty' => [[], []],
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