<?php

namespace Ethyl\Tests\Pipeline;

use ArrayIterator;
use Ethyl\Core\FunctionStage;
use Ethyl\Pipeline\Input;
use Ethyl\Pipeline\Output;
use Ethyl\Pipeline\Pipeline;
use Ethyl\Tests\AbstractTestCase;
use Exception;

/**
 * Pipeline Test
 *
 * @package Ethyl\Tests\Pipeline
 */
class PipelineTest extends AbstractTestCase
{
    /**
     * Tests running a pipeline with input, a transform and an output.
     */
    public function testRun()
    {
        $loaded   = null;
        $pipeline = new Pipeline();
        $pipeline
            ->setInput($this->getInput())
            ->pipe(new FunctionStage(function ($iterator) {
                foreach ($iterator as $item) {
                    yield $item * 2;
                }
            }))
            ->setOutput(new Output(new FunctionStage(function ($iterator) use (&$loaded) {
                $loaded = iterator_to_array($iterator, false);

                return $iterator;
            })));

        $pipeline->run();

        $this->assertEquals([2, 4, 6], $loaded);
    }

    /**
     * Tests the fluent interface.
     */
    public function testFluentInterface()
    {
        $pipeline = new Pipeline();

        $this->assertSame($pipeline, $pipeline->setInput($this->getInput()));
        $this->assertSame($pipeline, $pipeline->setOutput($this->getOutput()));
        $this->assertSame($pipeline, $pipeline->pipe(function ($item) {
            return $item;
        }));
    }

    /**
     * Tests running a pipeline without input.
     *
     * @throws Exception
     */
    public function testRunWithoutInput()
    {
        $pipeline = new Pipeline();
        $pipeline->setOutput($this->getOutput());

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Empty input!');
        $pipeline->run();
    }

    /**
     * Tests running a pipeline without output.
     *
     * @throws Exception
     */
    public function testRunWithoutOutput()
    {
        $pipeline = new Pipeline();
        $pipeline->setInput($this->getInput());

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Empty output');
        $pipeline->run();
    }

    /**
     * Tests running a pipeline more than once.
     *
     * @throws Exception
     */
    public function testRunTwice()
    {
        $pipeline = new Pipeline();
        $pipeline
            ->setInput($this->getInput())
            ->setOutput($this->getOutput());
        $pipeline->run();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('This pipeline has been already executed!');
        $pipeline->run();
    }

    /**
     * Returns the pipeline input.
     *
     * @return Input
     */
    protected function getInput(): Input
    {
        return new Input(new FunctionStage(function () {
            return new ArrayIterator([1, 2, 3]);
        }));
    }

    /**
     * Returns the pipeline output.
     *
     * @return Output
     */
    protected function getOutput(): Output
    {
        return new Output(new FunctionStage(function ($iterator) {
            return $iterator;
        }));
    }
}
