<?php

namespace Ethyl\Output;

use Ethyl\Core\IteratorStage;
use Iterator;

/**
 * Class StreamOutput
 * @package Ethyl\Output
 */
abstract class StreamOutput extends IteratorStage
{
    /**
     * {@inheritdoc
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
        }
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