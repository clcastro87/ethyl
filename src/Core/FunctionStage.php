<?php


namespace Ethyl\Core;

use Ethyl\Core\Traits\CallableAwareTrait;
use League\Pipeline\StageInterface;

/**
 * Stage that process a function.
 * @package Ethyl\Core
 */
class FunctionStage implements StageInterface
{
    use CallableAwareTrait;

    /**
     * FunctionStage constructor.
     *
     * @param callable $fn
     */
    public function __construct(callable $fn)
    {
        $this->setCallable($fn);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke($payload)
    {
        return $this->getCallable()($payload);
    }
}