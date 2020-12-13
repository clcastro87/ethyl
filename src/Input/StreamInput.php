<?php

namespace Ethyl\Input;

use Ethyl\Core\IteratorStage;
use InvalidArgumentException;
use Iterator;

/**
 * Stream input.
 *
 * @package Ethyl\Input
 */
abstract class StreamInput extends IteratorStage
{
    /**
     * {@inheritDoc}
     */
    public function __invoke($payload): Iterator
    {
        if (is_resource($payload) && get_resource_type($payload) === 'stream') {
            $iterator = $this->getIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to stream objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * Returns an iterator for accessing to the stream input
     *
     * @param $payload
     * @return Iterator
     */
    public abstract function getIterator($payload): Iterator;
}
