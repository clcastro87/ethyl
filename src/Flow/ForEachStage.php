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
     * Sub stage to run for each item.
     *
     * @var StageInterface
     */
    protected $subStage;

    /**
     * ForEachStage constructor.
     *
     * @param StageInterface $subStage
     */
    public function __construct(StageInterface $subStage)
    {
        parent::__construct();

        $this->subStage = $subStage;
    }

    /**
     * {@inheritDoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            yield $this->subStage->__invoke($item);
        }

        yield from [];
    }
}