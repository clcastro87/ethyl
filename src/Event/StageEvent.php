<?php

namespace Ethyl\Event;

use League\Event\EventInterface;

/**
 * Stage event.
 */
abstract class StageEvent implements EventInterface
{
    const EVENT_NAME = 'none';

    const DEFAULT_SCOPE = 'stage';

    /**
     * Event scope.
     *
     * @var string
     */
    protected $scope = self::DEFAULT_SCOPE;

    /**
     * Sets the event scope.
     *
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