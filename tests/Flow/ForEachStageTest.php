<?php

namespace Ethyl\Tests\Flow;

use Ethyl\Core\FunctionStage;
use Ethyl\Flow\ForEachStage;
use Ethyl\Tests\Core\IteratorStageTest;

/**
 * ForEachStage Test
 *
 * @package Ethyl\Tests\Flow
 */
class ForEachStageTest extends IteratorStageTest
{
    /**
     * {@inheritDoc}
     */
    public function getIteratorStage()
    {
        $stage = new FunctionStage(function ($item) {
            return $item * 2;
        });

        return new ForEachStage($stage);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData(): array
    {
        return [
            'Array' => [range(0, 5), [0, 2, 4, 6, 8, 10]],
            'Empty' => [[], []],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getIteratorData(): array
    {
        return $this->getTestData();
    }
}