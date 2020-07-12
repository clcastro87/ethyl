<?php

namespace Ethyl\Output;

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
        $isHeader = true;

        foreach ($iterator as $item) {
            if ($isHeader) {
                $this->writeHeader($item);
                $isHeader = false;
            }
            $this->writeItem($item);
            if (!$this->drain) {
                yield $item;
            }
        }

        yield from [];
    }

    /**
     * Writes a header to the output stream
     *
     * @param $item
     * @return void
     */
    public function writeHeader($item) {}

    /**
     * Writes an item to the output stream
     *
     * @param $item
     * @return void
     */
    public abstract function writeItem($item);
}