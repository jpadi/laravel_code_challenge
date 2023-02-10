<?php

namespace App\BoundedContext\Core\Model\Aggregates;

use App\BoundedContext\Core\Model\EventBus\Event;

abstract class AggregateRoot
{
    /**
     * @var Event[]
     */
    protected $events = [];

    /**
     * @param Event $event
     * @return void
     */
    final protected function addEvent(Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * return current event list and empty it
     * @return Event[]
     */
    final public function pollEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

}
