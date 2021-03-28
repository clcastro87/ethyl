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
    private $formatProcessor;

    /**
     * Input constructor.
     *
     * @param Stage $input
     * @param Stage|null $formatProcessor
     */
    public function __construct(Stage $input, Stage $formatProcessor = null)
    {
        $this->input = $input;
        $this->formatProcessor = $formatProcessor;
    }

    /**
     * Extracts the input.
     *
     * @param mixed|null $payload
     * @return Iterator
     */
    public function extract($payload = null): Iterator
    {
        $data = $this->input->__invoke($payload);

        return empty($this->formatProcessor) ? $data : $this->formatProcessor->__invoke($data);
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