<?php

declare(strict_types=1);

namespace Ethyl\Pipeline;

use Exception;
use League\Pipeline\FingersCrossedProcessor;
use League\Pipeline\PipelineBuilder;

/**
 * ETL Pipeline
 *
 * @package Ethyl\Pipeline
 */
class Pipeline
{
    /**
     * @var bool
     */
    protected $ran;

    /**
     * @var Input
     */
    protected $input;

    /**
     * @var Output
     */
    protected $output;

    /**
     * @var array
     */
    protected $transforms;

    /**
     * @var PipelineBuilder
     */
    protected $pipelineBuilder;

    /**
     * Pipeline constructor.
     */
    public function __construct()
    {
        $this->ran = false;
        $this->transforms = [];
        $this->pipelineBuilder = new PipelineBuilder();
    }

    public function setInput(Input $input)
    {
        $this->input = $input;

        return $this;
    }

    public function setOutput(Output $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Pipes a stage to transform the input before returning an output.
     *
     * @param callable $transform
     * @return $this
     */
    public function pipe(callable $transform): self
    {
        $this->transforms[] = $transform;

        return $this;
    }

    /**
     * Runs the pipeline.
     *
     * @throws Exception
     */
    public function run(): void
    {
        if ($this->ran) {
            throw new Exception('This pipeline has been already executed!');
        }

        $this->ran = true;

        if (empty($this->input)) {
            throw new Exception('Empty input!');
        }
        if (empty($this->output)) {
            throw new Exception('Empty output');
        }

        // Add stages
        $this->pipelineBuilder->add($this->input);
        foreach ($this->transforms as $transform) {
            $this->pipelineBuilder->add($transform);
        }
        $this->pipelineBuilder->add($this->output);
        // Build pipeline
        $pipeline = $this->pipelineBuilder->build(new FingersCrossedProcessor());
        // Run
        $pipeline(null);
    }
}
