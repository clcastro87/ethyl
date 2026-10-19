<?php

declare(strict_types=1);

namespace Ethyl\IO;

use InvalidArgumentException;
use League\Flysystem\Local\LocalFilesystemAdapter;

final class FilesystemBuilder
{
    private const DRIVERS = [
        'local' => LocalFilesystemAdapter::class,
    ];

    /**
     * Builds a filesystem for the given driver.
     *
     * @param string $driver
     * @param string $name
     * @param mixed ...$options
     * @return Filesystem
     * @throws InvalidArgumentException
     */
    public static function build(string $driver, string $name, ...$options): Filesystem
    {
        if (!isset(self::DRIVERS[$driver])) {
            throw new InvalidArgumentException("The filesystem driver {$driver} was not found!");
        }

        $adapterClass = self::DRIVERS[$driver];
        $adapter      = new $adapterClass(...$options);

        return new Filesystem($driver, $adapter, $name);
    }
}
