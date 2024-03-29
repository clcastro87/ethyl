<?php

namespace Ethyl\Tests\Flow;

use Ethyl\Flow\DeAggregator;
use Ethyl\Tests\Core\IteratorStageTest;

/**
 * DeAggregator Test
 *
 * @package Ethyl\Tests\Flow
 */
class DeAggregatorTest extends IteratorStageTest
{
    /**
     * @inheritDoc
     */
    public function getIteratorStage()
    {
        return new DeAggregator();
    }

    /**
     * @inheritDoc
     */
    public function getTestData(): array
    {
        return [
            'Array' => [[[0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10]], range(0, 10)],
            'Empty' => [[], []],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIteratorData(): array
    {
        return $this->getTestData();
    }
}
