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
    private $processor;

    /**
     * Output constructor.
     *
     * @param Stage $output
     * @param Stage|null $processor
     */
    public function __construct(Stage $output, Stage $processor = null)
    {
        $this->output = $output;
        $this->processor = $processor;
    }

    /**
     * Loads the output.
     *
     * @param Iterator $data
     */
    public function load(Iterator $data): void
    {
        $data = empty($this->processor) ? $data : $this->processor->__invoke($data);

        $this->output->__invoke($data);
    }
}