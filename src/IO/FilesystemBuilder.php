<?php

declare(strict_types=1);

namespace Ethyl\IO;

use League\Flysystem\Adapter\Local;
use League\Flysystem\FilesystemNotFoundException;

final class FilesystemBuilder
{
    private const DRIVERS = [
        'local' => Local::class,
    ];

    public static function build(string $driver, string $name, ...$options): Filesystem
    {
        if (!isset(self::DRIVERS[$driver])) {
            throw new FilesystemNotFoundException("The filesystem driver {$driver} was not found!");
        }

        $adapterClass = self::DRIVERS[$driver];
        $adapter      = new $adapterClass(...$options);

        return new Filesystem($driver, $adapter, $name);
    }
}
