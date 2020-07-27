<?php

namespace Ethyl\Output;

use EmptyIterator;
use Iterator;

/**
 * Abstract implementation for output to stream.
 *
 * @package Ethyl\Output
 */
abstract class StreamOutput extends AbstractOutput
{
    /**
     * {@inheritdoc}
     */
    public function iterate(Iterator $iterator)
    {
        $this->writeHeader($iterator);
        return $this->writeContent($iterator);
    }

    /**
     * Writes a header to the output stream
     *
     * @param Iterator $iterator
     * @return void
     */
    public function writeHeader(Iterator $iterator)
    {
    }

    /**
     * Writes the content of a file.
     *
     * @param Iterator $iterator
     * @return Iterator
     */
    public function writeContent(Iterator $iterator)
    {
        foreach ($iterator as $item) {
            $this->writeItem($item);
        }

        if (!$this->drain) {
            $iterator->rewind();
            return $iterator;
        } else {
            return new EmptyIterator();
        }
    }

    /**
     * Writes an item to the output stream
     *
     * @param $item
     * @return void
     */
    public abstract function writeItem($item);
}
