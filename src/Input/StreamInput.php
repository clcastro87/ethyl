<?php

namespace Ethyl\Input;

use Ethyl\Core\IteratorStage;
use Exception;
use Iterator;

/**
 * Class StreamInput
 * @package Ethyl\Input
 */
abstract class StreamInput extends IteratorStage
{
    /**
     * @{inheritdoc}
     * @param $payload
     * @return Iterator
     * @throws Exception
     */
    public function __invoke($payload)
    {
        if (is_resource($payload) && get_resource_type($payload) === 'stream') {
            $iterator = $this->getIterator($payload);
        } else {
            throw new Exception('This stage is only applicable to stream objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * Returns an iterator for accessing to the stream input
     *
     * @param $payload
     * @return Iterator
     */
    public abstract function getIterator($payload);

    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        return $iterator;
    }
}