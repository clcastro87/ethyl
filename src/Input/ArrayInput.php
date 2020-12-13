<?php

namespace Ethyl\Input;

use ArrayIterator;
use Ethyl\Core\IteratorStage;
use InvalidArgumentException;
use Iterator;

/**
 * Iterates over the items on an array.
 *
 * @package Ethyl\Input
 */
class ArrayInput extends IteratorStage
{
    /**
     * {@inheritDoc}
     */
    public function __invoke($payload): Iterator
    {
        if (is_array($payload)) {
            $iterator = new ArrayIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to array objects.');
        }

        return $this->iterate($iterator);
    }
}
