<?php

namespace Ethyl\Input;

use Exception;
use InvalidArgumentException;
use Iterator;
use League\Csv\Reader;

/**
 * CSV File Input
 * 
 * @package Ethyl\Input
 */
class CsvFileInput extends CsvStreamInput
{
    /**
     * @{inheritdoc}
     * @param $payload
     * @return Iterator
     * @throws Exception
     */
    public function __invoke($payload)
    {
        if (is_string($payload)) {
            $iterator = $this->getIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to string objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator($payload)
    {
        $reader = Reader::createFromPath($payload);
        $reader->setDelimiter($this->delimiter)
               ->setHeaderOffset(0);

        return $reader->getRecords();
    }
}