<?php

declare(strict_types=1);

namespace Ethyl\Core;

use Ethyl\Core\Traits\CallableAwareTrait;

/**
 * Stage that process a function.
 *
 * @package Ethyl\Core
 */
class FunctionStage extends Stage
{
    use CallableAwareTrait;

    /**
     * FunctionStage constructor.
     *
     * @param callable $fn
     */
    public function __construct(callable $fn)
    {
        $this->callable = $fn;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function __invoke($payload)
    {
        return ($this->callable)($payload);
    }
}
