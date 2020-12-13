<?php

namespace Ethyl\Filter;

use Ethyl\Core\Traits\DebuggableTrait;

/**
 * Value filter abstraction.
 *
 * @package Ethyl\Filter
 */
abstract class ValueFilter implements FilterInterface
{
    use DebuggableTrait;

    /**
     * @inheritDoc
     */
    public function __invoke($value): bool
    {
        return $this->satisfy($value);
    }

    /**
     * @inheritDoc
     */
    public abstract function satisfy($value): bool;

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        return [
            'filter' => $this->getClassName(),
        ];
    }
}