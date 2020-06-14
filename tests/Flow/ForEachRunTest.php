<?php


namespace Ethyl\Tests\Flow;

use Closure;
use Ethyl\Flow\ForEachRun;
use Ethyl\Tests\Core\IteratorStageTest;

/**
 * Class ForEachRunTest
 * @package Ethyl\Tests\Flow
 */
class ForEachRunTest extends IteratorStageTest
{
    /**
     * {@inheritDoc}
     */
    public function getIteratorStage()
    {
        $closure = Closure::fromCallable(function ($item) {
            return $item * 2;
        });

        return new ForEachRun($closure);
    }

    /**
     * {@inheritDoc}
     */
    public function getTestData()
    {
        return [
            'Array' => [range(0, 5), [0, 2, 4, 6, 8, 10]],
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