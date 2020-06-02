<?php

namespace Ethyl\Input;

use Exception;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Pipeline\StageInterface;

/**
 * Filesystem abstraction for remote local/remote inputs. Returns an stream that can be used by other stream input processors.
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
     * {@inheritDoc}
     * @throws Exception
     */
    public function __invoke($payload)
    {
        if (!is_string($payload)) {
            throw new Exception('This stage is only applicable to a path input.');
        }

        return $this->fileSystem->readStream($payload);
    }
}