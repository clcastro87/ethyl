<?php


namespace Ethyl\Flow;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class ForEachStage
 * @package Ethyl\Flow
 */
class ForEachStage extends IteratorStage
{
    /**
     * {@inheritDoc}
     */
    public function iterate(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            yield $item;
        }
    }
}