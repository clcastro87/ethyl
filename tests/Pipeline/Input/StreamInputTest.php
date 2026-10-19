<?php

namespace Ethyl\Tests\Pipeline\Input;

use Ethyl\Input\CsvFileInput;
use Ethyl\Input\CsvStreamInput;
use Ethyl\Pipeline\Input\StreamInput;
use Ethyl\Tests\AbstractTestCase;

/**
 * StreamInput Test
 *
 * @package Ethyl\Tests\Pipeline\Input
 */
class StreamInputTest extends AbstractTestCase
{
    /**
     * Tests the extract feature.
     */
    public function testExtract()
    {
        $stream = $this->getStream();
        $input  = $this->getInput($stream);

        $data = iterator_to_array($input->extract(), false);
        fclose($stream);

        $this->assertNotEmpty($data);
    }

    /**
     * Tests the invoke feature.
     */
    public function testInvoke()
    {
        $stream = $this->getStream();
        $input  = $this->getInput($stream);

        $data = iterator_to_array($input(), false);
        fclose($stream);

        $this->assertNotEmpty($data);
    }

    /**
     * Returns the pipeline input.
     *
     * @param resource $stream
     * @return StreamInput
     */
    protected function getInput($stream): StreamInput
    {
        return new StreamInput($stream, new CsvStreamInput(CsvFileInput::CSV_DELIMITER_COMMA));
    }

    /**
     * Returns the stream to read from.
     *
     * @return resource
     */
    protected function getStream()
    {
        return fopen(__DIR__ . '/../../Resources/sales.csv', 'r');
    }
}
