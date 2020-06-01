<?php

namespace Ethyl\Input;

use ArrayIterator;
use Ethyl\Core\IteratorStage;
use Exception;
use Iterator;

/**
 * Iterates over the items on an array.
 * 
 * @package Ethyl\Input
 */
class ArrayInput extends IteratorStage
{
    /**
     * @{inheritdoc}
     * @param $payload
     * @return Iterator
     * @throws Exception
     */
    public function __invoke($payload)
    {
        if (is_array($payload)) {
            $iterator = new ArrayIterator($payload);
        } else {
            throw new Exception('This stage is only applicable to array objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        return $iterator;
    }
}