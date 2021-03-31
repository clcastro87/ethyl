<?php

declare(strict_types=1);

namespace Ethyl\Input;

use Exception;
use InvalidArgumentException;
use Iterator;
use League\Csv\Reader;

/**
 * CSV File Input.
 *
 * @package Ethyl\Input
 */
class CsvFileInput extends CsvStreamInput
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function __invoke($payload): Iterator
    {
        if (is_string($payload)) {
            $iterator = $this->getIterator($payload);
        } else {
            throw new InvalidArgumentException('This stage is only applicable to string objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * @inheritDoc
     */
    public function getIterator($payload): Iterator
    {
        $reader = Reader::createFromPath($payload);
        $reader->setDelimiter($this->delimiter)
               ->setHeaderOffset(0);

        return $reader->getRecords();
    }
}
