<?php

namespace Ethyl\Core;

use ArrayIterator;
use InvalidArgumentException;
use Iterator;
use League\Pipeline\StageInterface;

/**
 * Abstract stage who works with iterators/generators.
 * 
 * @package Ethyl\Core
 */
abstract class IteratorStage extends Stage
{
    /**
     * @{inheritdoc}
     * @param $payload
     * @return Iterator
     * @throws InvalidArgumentException
     */
    public function __invoke($payload)
    {
        if (is_array($payload)) {
            $iterator = new ArrayIterator($payload);
        } else if ($payload instanceof Iterator) {
            $iterator = $payload;
        } else {
            throw new InvalidArgumentException('This stage is only applicable to iterable objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * @param Iterator $iterator
     * @return Iterator
     */
    public abstract function iterate(Iterator $iterator);
}