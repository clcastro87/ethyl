<?php

declare(strict_types=1);

namespace Ethyl\Pipeline;

use Ethyl\Core\Stage;
use Iterator;

/**
 * Pipeline Input
 *
 * @package Ethyl\Pipeline
 */
class Input
{
    /**
     * @var Stage
     */
    private $input;

    /**
     * Input constructor.
     *
     * @param Stage $input
     */
    public function __construct(Stage $input)
    {
        $this->input = $input;
    }

    /**
     * Extracts the input.
     *
     * @param mixed|null $payload
     * @return Iterator
     */
    public function extract($payload = null): Iterator
    {
        return $this->input->__invoke($payload);
    }

    /**
     * Handles invoke of the object as a function.
     *
     * @param mixed|null $payload
     * @return Iterator
     */
    public function __invoke($payload = null): Iterator
    {
        return $this->extract($payload);
    }
}
