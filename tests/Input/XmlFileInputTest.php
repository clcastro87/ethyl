<?php

namespace Ethyl\Tests\Input;

use Ethyl\Input\XmlFileInput;
use Ethyl\Tests\AbstractTestCase;
use Exception;
use InvalidArgumentException;

/**
 * XmlFileInput Test
 *
 * @package Ethyl\Tests\Input
 */
class XmlFileInputTest extends AbstractTestCase
{
    /**
     * Tests the XmlFileInput specifying a file path.
     *
     * @throws Exception
     */
    public function testInputFilePath()
    {
        $input    = new XmlFileInput('book');
        $iterator = $input($this->getFilePath());
        $data     = iterator_to_array($iterator);
        $this->assertNotEmpty($data);
    }

    /**
     * Tests the XmlFileInput specifying an array.
     *
     * @throws Exception
     */
    public function testInputInvalidInput()
    {
        $input = new XmlFileInput('book');
        $this->expectException(InvalidArgumentException::class);
        $input([$this->getFilePath()]);
    }

    /**
     * Returns the test file path.
     *
     * @return string
     */
    protected function getFilePath(): string
    {
        return __DIR__ . '/../Resources/books.xml';
    }
}