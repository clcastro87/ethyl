<?php

namespace Ethyl\Input;

use InvalidArgumentException;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Pipeline\StageInterface;

/**
 * Filesystem abstraction for remote local/remote inputs. Returns an stream that can be used by other input stream processors.
 *
 * @package Ethyl\Input
 */
class FlySystemInput implements StageInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $fileSystem;

    /**
     * FlySystemInput constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->fileSystem = new Filesystem($adapter);
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     * @throws FileNotFoundException
     */
    public function __invoke($payload)
    {
        if (!is_string($payload)) {
            throw new InvalidArgumentException('This stage is only applicable to a path input.');
        }

        return $this->fileSystem->readStream($payload);
    }
}
