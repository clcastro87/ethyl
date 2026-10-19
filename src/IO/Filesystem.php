<?php

declare(strict_types=1);

namespace Ethyl\IO;

use League\Flysystem\Filesystem as LeagueFilesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\UnableToReadFile;

class Filesystem
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $driver;

    /**
     * @var FilesystemAdapter
     */
    private $internalFilesystem;

    /**
     * Filesystem constructor.
     *
     * @param string $driver
     * @param FilesystemAdapter $adapter
     * @param string|null $name
     */
    public function __construct(string $driver, FilesystemAdapter $adapter, string $name = null)
    {
        $this->driver             = $driver;
        $this->name               = empty($name) ? $this->driver : $name;
        $this->internalFilesystem = new LeagueFilesystem($adapter);
    }

    /**
     * Reads a stream.
     *
     * @param string $path
     * @return resource
     * @throws UnableToReadFile
     */
    public function readStream(string $path)
    {
        return $this->internalFilesystem->readStream($path);
    }
}
