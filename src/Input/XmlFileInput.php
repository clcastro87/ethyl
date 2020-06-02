<?php

namespace Ethyl\Input;

use Exception;
use Iterator;

/**
 * Xml File Input
 */
class XmlFileInput extends XmlStreamInput
{
    /**
     * @{inheritdoc}
     *
     * @param $payload
     * @return Iterator
     * @throws Exception
     */
    public function __invoke($payload)
    {
        if (is_string($payload)) {
            $iterator = $this->getIterator($payload);
        } else {
            throw new Exception('This stage is only applicable to a string input.');
        }

        return $this->iterate($iterator);
    }
}