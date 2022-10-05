<?php

declare(strict_types=1);

namespace Ethyl\Core;

use Ethyl\Helper\IteratorTools;
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

        return $this->iterate(IteratorTools::convertToIterator($payload));
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
