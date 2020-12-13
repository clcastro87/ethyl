<?php

namespace Ethyl\Input;

use InvalidArgumentException;
use Iterator;

/**
 * Xml File Input.
 *
 * @package Ethyl\Input
 */
class XmlFileInput extends XmlStreamInput
{
    /**
     * {@inheritDoc}
     */
    public function __invoke($payload): Iterator
    {
        if (is_string($payload)) {
            $iterator = $this->getIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to a string input.');
        }

        return $this->iterate($iterator);
    }
}
