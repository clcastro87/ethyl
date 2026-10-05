<?php

namespace Ethyl\Tests\Flow;

use Ethyl\Flow\BatchAggregator;
use Ethyl\Tests\Core\IteratorStageTest;
use InvalidArgumentException;

/**
 * BatchAggregator Test
 *
 * @package Ethyl\Tests\Flow
 */
class BatchAggregatorTest extends IteratorStageTest
{
    /**
     * @dataProvider getInvalidBatchSizes
     */
    public function testConstructorRejectsInvalidBatchSize(int $batchSize): void
    {
        $this->expectException(InvalidArgumentException::class);

        new BatchAggregator($batchSize);
    }

    public function getInvalidBatchSizes(): array
    {
        return [
            'zero'     => [0],
            'negative' => [-1],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getIteratorStage()
    {
        return new BatchAggregator(3);
    }

    /**
     * @inheritDoc
     */
    public function getTestData(): array
    {
        return [
            'Array' => [range(0, 10), [[0, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10]]],
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
