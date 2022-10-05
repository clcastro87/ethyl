<?php

declare(strict_types=1);

namespace Ethyl\Filter;

use Ethyl\Helper\Reflection;

/**
 * Value filter abstraction.
 *
 * @package Ethyl\Filter
 */
abstract class ValueFilter implements FilterInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke($value): bool
    {
        return $this->accept($value);
    }

    /**
     * @inheritDoc
     */
    public abstract function accept($value): bool;

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        return [
            'filter' => Reflection::getClassName(static::class),
        ];
    }
}