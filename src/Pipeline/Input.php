<?php

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
     * @var Stage|null
     */
    private $processor;

    /**
     * Input constructor.
     *
     * @param Stage $input
     * @param Stage|null $processor
     */
    public function __construct(Stage $input, Stage $processor = null)
    {
        $this->input = $input;
        $this->processor = $processor;
    }

    /**
     * Extracts the input.
     *
     * @param null $payload
     * @return Iterator
     */
    public function extract($payload = null): Iterator
    {
        $data = $this->input->__invoke($payload);

        return empty($this->processor) ? $data : $this->processor->__invoke($data);
    }
}