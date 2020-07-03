<?php

namespace Ethyl\Event;

use League\Event\Event;

/**
 * Stage event.
 *
 * @package Ethyl\Event
 */
abstract class StageEvent extends Event
{
    /**
     * Event name.
     */
    const EVENT_NAME = 'none';

    /**
     * Event scope.
     */
    const DEFAULT_SCOPE = 'stage';

    /**
     * Event scope.
     *
     * @var string
     */
    protected $scope = self::DEFAULT_SCOPE;

    /**
     * StageEvent constructor.
     */
    public function __construct()
    {
        parent::__construct($this->getName());
    }

    /**
     * Sets the event scope.
     *
     * @param string $scope
     * @return void
     */
    public function setScope(string $scope)
    {
        $this->scope = $scope;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return !empty($this->scope) ? sprintf('%s.%s', $this->scope, static::EVENT_NAME) : sprintf('%s.%s', self::DEFAULT_SCOPE, static::EVENT_NAME);
    }
}