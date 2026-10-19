<?php

declare(strict_types=1);

namespace Ethyl\Input;

use InvalidArgumentException;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToReadFile;
use League\Pipeline\StageInterface;

/**
 * Filesystem abstraction for remote local/remote inputs. Returns an stream that can be used by other input stream processors.
 *
 * @package Ethyl\Input
 */
class FlySystemInput implements StageInterface
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * FlySystemInput constructor.
     *
     * @param FilesystemAdapter $adapter
     */
    public function __construct(FilesystemAdapter $adapter)
    {
        $this->fileSystem = new Filesystem($adapter);
    }

    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     * @throws UnableToReadFile
     */
    public function __invoke($payload)
    {
        if (!is_string($payload)) {
            throw new InvalidArgumentException('This stage is only applicable to a path input.');
        }

        return $this->fileSystem->readStream($payload);
    }
}
