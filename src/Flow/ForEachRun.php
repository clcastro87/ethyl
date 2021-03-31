<?php

declare(strict_types=1);

namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use Closure;
use Iterator;

/**
 * Runs a function for each item present on the iterator.
 *
 * @package Ethyl\Flow
 */
class ForEachRun extends IteratorStage
{
    /**
     * fn to run for each item.
     *
     * @var Closure
     */
    protected $closure;

    /**
     * ForEachRun constructor.
     *
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        parent::__construct();

        $this->closure = $closure;
    }

    /**
     * @inheritDoc
     */
    public function iterate(Iterator $iterator): Iterator
    {
        foreach ($iterator as $item) {
            yield $this->closure->__invoke($item);
        }

        yield from [];
    }
}
