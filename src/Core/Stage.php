<?php

declare(strict_types=1);

namespace Ethyl\Core;

use Ethyl\Core\Traits\DebuggableTrait;
use League\Pipeline\StageInterface;

/**
 * Abstract stage.
 *
 * @package Ethyl\Core
 */
abstract class Stage implements StageInterface, DebuggableInterface
{
    use DebuggableTrait;

    /**
     * Stage name.
     *
     * @var string
     */
    protected $stageName;

    /**
     * Identifier for the stage.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Stage constructor.
     */
    public function __construct()
    {
        $this->stageName  = $this->getStageName();
        $this->identifier = uniqid();
    }

    /**
     * Returns the stage name.
     *
     * @return string
     */
    protected function getStageName(): string
    {
        return $this->getClassName();
    }

    /**
     * @inheritDoc
     */
    public function debug(): array
    {
        return [
            'stage'      => $this->stageName,
            'identifier' => $this->identifier,
        ];
    }
}
