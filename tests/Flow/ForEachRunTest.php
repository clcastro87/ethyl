<?php

namespace Ethyl\Tests\Flow;

use Closure;
use Ethyl\Flow\ForEachRun;
use Ethyl\Tests\Core\IteratorStageTest;
use stdClass;

/**
 * ForEachRun Test
 *
 * @package Ethyl\Tests\Flow
 */
class ForEachRunTest extends IteratorStageTest
{
    /**
     * @inheritDoc
     */
    public function getIteratorStage()
    {
        $closure = Closure::bind(function ($item) {
            return $item * 2;
        }, new stdClass());

        return new ForEachRun($closure);
    }

    /**
     * @inheritDoc
     */
    public function getTestData(): array
    {
        return [
            'Array' => [range(0, 5), [0, 2, 4, 6, 8, 10]],
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