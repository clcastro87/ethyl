<?php

declare(strict_types=1);

namespace Ethyl\Core;

use Exception;
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
     * @inheritDoc
     * @return Iterator
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function __invoke($payload): Iterator
    {
        if (!is_iterable($payload)) {
            throw new InvalidArgumentException('This stage is only applicable to iterable objects.');
        }

        if (is_array($payload)) {
            $iterator = new \ArrayIterator($payload);
        } else if ($payload instanceof \IteratorAggregate) {
            $iterator = $payload->getIterator();
        } else if (!$payload instanceof \Iterator) {
            $iterator = new \IteratorIterator($payload);
        } else {
            $iterator = $payload;
        }

        return $this->iterate($iterator);
    }

    /**
     * Iterates through items on iterator and returns a new iterator with data processed.
     *
     * @param Iterator $iterator
     * @return Iterator
     */
    public function iterate(Iterator $iterator): Iterator
    {
        return $iterator;
    }
}
