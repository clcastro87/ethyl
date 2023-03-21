<?php

declare(strict_types=1);

namespace Ethyl\IO;

use League\Flysystem\AdapterInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem as LeagueFilesystem;

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
     * @var AdapterInterface
     */
    private $internalFilesystem;

    /**
     * Filesystem constructor.
     *
     * @param string $driver
     * @param AdapterInterface $adapter
     * @param string|null $name
     */
    public function __construct(string $driver, AdapterInterface $adapter, string $name = null)
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
     * @throws FileNotFoundException
     */
    public function readStream(string $path)
    {
        return $this->internalFilesystem->readStream($path);
    }
}
