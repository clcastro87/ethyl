<?php

namespace Ethyl\Core;

use ArrayIterator;
use Exception;
use Generator;
use Iterator;
use League\Pipeline\StageInterface;

/**
 * Class IteratorStage
 * @package Ethyl\Core
 */
abstract class IteratorStage implements StageInterface
{
    /**
     * @{inheritdoc}
     * @param $payload
     * @return Generator
     * @throws Exception
     */
    public function __invoke($payload)
    {
        if (is_array($payload)) {
            $iterator = new ArrayIterator($payload);
        } else if ($payload instanceof Iterator) {
            $iterator = $payload;
        } else {
            throw new Exception('This stage is only applicable to iterable objects.');
        }

        return $this->iterate($iterator);
    }

    /**
     * @param Iterator $iterator
     * @return Generator
     */
    public abstract function iterate(Iterator $iterator);
}