<?php

namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use Iterator;
use League\Pipeline\StageInterface;

/**
 * Runs a stage for each item present on the iterator.
 * 
 * @package Ethyl\Flow
 */
class ForEachStage extends IteratorStage
{
    /**
     * Substage to run for each item.
     *
     * @var StageInterface
     */
    protected $subStage;

    /**
     * {@inheritDoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            $result = $this->subStage->__invoke($item);
            yield $result;
        }

        yield from [];
    }
}