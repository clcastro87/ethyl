<?php

declare(strict_types=1);

namespace Ethyl\Filter;

use Ethyl\Core\IteratorStage;
use Ethyl\Helper\Reflection;
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

    /**
     * Iterator Filter Constructor.
     *
     * @param FilterInterface $filter
     */
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
        // TODO: Optimize with SPL internals
        foreach ($iterator as $item) {
            if ($this->filter->accept($item)) {
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
            'iterator_filter' => Reflection::getClassName(static::class),
            'filter'          => $this->filter->debug(),
        ];
    }
}
