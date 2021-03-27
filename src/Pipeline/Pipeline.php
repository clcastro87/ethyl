<?php


namespace Ethyl\Pipeline;

use Exception;
use League\Pipeline\Pipeline as BasePipeline;

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
     * Pipeline constructor.
     */
    public function __construct()
    {
        $this->ran = false;
        $this->transforms = [];
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

        $inputIterator = $this->input->extract();
        $transformed = (new BasePipeline(null, ...$this->transforms))->process($inputIterator);
        $this->output->load($transformed);
    }
}