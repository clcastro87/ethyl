<?php

declare(strict_types=1);

namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use Ethyl\Core\Traits\CallableAwareTrait;
use Iterator;

/**
 * Runs a function for each item present on the iterator.
 *
 * @package Ethyl\Flow
 */
class ForEachRun extends IteratorStage
{
    use CallableAwareTrait;

    /**
     * ForEachRun constructor.
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        parent::__construct();

        $this->callable = $callable;
    }

    /**
     * @inheritDoc
     */
    public function iterate(Iterator $iterator): Iterator
    {
        foreach ($iterator as $item) {
            yield call_user_func($this->callable, $item);
        }

        yield from [];
    }
}
