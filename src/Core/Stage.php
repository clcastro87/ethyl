<?php

namespace Ethyl\Core;

use Ethyl\Core\Traits\DebuggableTrait;
use Ethyl\Event\EventAggregator;
use Ethyl\Event\StageInitializedEvent;
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

        $this->fireEvent(StageInitializedEvent::class);
        $this->fireGlobalEvent(StageInitializedEvent::class);
    }

    /**
     * Returns the stage name.
     *
     * @return string
     */
    protected function getStageName()
    {   
        return $this->getClassName();
    }

    /**
     * Returns event scope.
     *
     * @return string
     */
    protected function getStageScope()
    {
        return sprintf("event.stage.%s.%s", strtolower($this->stageName), $this->identifier);
    }

    /**
     * Fires a local event.
     *
     * @param string $eventClass
     * @param array $args
     * @return void
     */
    protected function fireEvent(string $eventClass, ...$args)
    {
        $event = new $eventClass(...$args);
        if (method_exists($event, 'setScope')) {
            $event->setScope($this->getStageScope());
        }

        EventAggregator::getInstance()->emit($event);
    }

    /**
     * Fires an event.
     *
     * @param string $eventClass
     * @param array $args
     * @return void
     */
    protected function fireGlobalEvent(string $eventClass, ...$args)
    {
        $event = new $eventClass(...$args);

        EventAggregator::getInstance()->emit($event);
    }

    /**
     * {@inheritDoc}
     */
    public function debug()
    {
        return [
            'stage'       => $this->stageName,
            'identifier'  => $this->identifier,
            'event_scope' => $this->getStageScope(),
        ];
    }
}