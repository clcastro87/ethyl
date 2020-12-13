<?php

namespace Ethyl\Filter;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Iterator filter.
 *
 * @package Ethyl\Filter
 */
class IteratorFilter extends IteratorStage
{
    /**
     * @var FilterInterface
     */
    protected $filter;

    public function __construct(FilterInterface $filter)
    {
        parent::__construct();

        $this->filter = $filter;
    }

    /**
     * @inheritDoc
     */
    public function iterate(Iterator $iterator): Iterator
    {
        foreach ($iterator as $item) {
            if ($this->filter->satisfy($item)) {
                yield $item;
            }
        }

        yield from [];
    }

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        return [
            'iterator_filter' => $this->getClassName(),
            'filter'          => $this->filter->debug(),
        ];
    }
}
