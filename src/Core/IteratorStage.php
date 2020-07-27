<?php

namespace Ethyl\Core;

use ArrayIterator;
use InvalidArgumentException;
use Iterator;

/**
 * Abstract stage who works with iterators/generators.
 *
 * @package Ethyl\Core
 */
abstract class IteratorStage extends Stage
{
    /**
     * {@inheritDoc}
     * @return Iterator
     * @throws InvalidArgumentException
     */
    public function __invoke($payload)
    {
        if (is_array($payload)) {
            $iterator = new ArrayIterator($payload);
        } elseif ($payload instanceof Iterator) {
            $iterator = $payload;
        } else {
            throw new InvalidArgumentException('This stage is only applicable to iterable objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * Iterates through items on iterator and returns a new iterator with data processed.
     *
     * @param Iterator $iterator
     * @return Iterator
     */
    public function iterate(Iterator $iterator)
    {
        return $iterator;
    }
}
