<?php

namespace Ethyl\Pipeline;

use Ethyl\Core\Stage;
use Iterator;

/**
 * Pipeline Output
 *
 * @package Ethyl\Pipeline
 */
class Output
{
    /**
     * @var Stage
     */
    private $output;

    /**
     * @var Stage|null
     */
    private $formatProcessor;

    /**
     * Output constructor.
     *
     * @param Stage $output
     * @param Stage|null $formatProcessor
     */
    public function __construct(Stage $output, Stage $formatProcessor = null)
    {
        $this->output = $output;
        $this->formatProcessor = $formatProcessor;
    }

    /**
     * Loads the output.
     *
     * @param Iterator $data
     */
    public function load(Iterator $data): void
    {
        $data = empty($this->formatProcessor) ? $data : $this->formatProcessor->__invoke($data);

        $this->output->__invoke($data);
    }

    /**
     * Handles invoke of the object as a function.
     *
     * @param Iterator $data
     */
    public function __invoke(Iterator $data): void
    {
        $this->load($data);
    }
}