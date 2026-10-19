<?php

namespace Ethyl\Tests\IO;

use Ethyl\IO\FilesystemBuilder;
use Ethyl\Tests\AbstractTestCase;
use InvalidArgumentException;

/**
 * FilesystemBuilder Test
 *
 * @package Ethyl\Tests\IO
 */
class FilesystemBuilderTest extends AbstractTestCase
{
    /**
     * Tests building a local filesystem and reading a stream from it.
     */
    public function testBuildLocalDriver()
    {
        $filesystem = FilesystemBuilder::build('local', 'local', '/');
        $stream     = $filesystem->readStream($this->getFilePath());

        $this->assertIsResource($stream);
        $this->assertSame(file_get_contents($this->getFilePath()), stream_get_contents($stream));
    }

    /**
     * Tests building an unknown driver.
     */
    public function testBuildUnknownDriver()
    {
        $this->expectException(InvalidArgumentException::class);
        FilesystemBuilder::build('unknown', 'unknown', '/');
    }

    /**
     * Returns the test file path.
     *
     * @return string
     */
    protected function getFilePath(): string
    {
        return __DIR__ . '/../Resources/sales.csv';
    }
}
