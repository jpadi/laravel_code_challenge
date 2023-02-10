<?php

namespace App\BoundedContext\Core\Infra\EventBus\SimpleInMemory;

use App\BoundedContext\Core\Model\EventBus\Event;
use App\BoundedContext\Core\Model\EventBus\EventBus;

class SimpleInMemoryEventBus implements EventBus
{

    private $eventHandlers = [];

    public function subscribe(string $evenName, callable $eventHandler)
    {
        $this->eventHandlers[$evenName][] = $eventHandler;
    }

    public function publish(Event ...$events): void
    {
        foreach ($events as $event) {
            $eventHandlersForEvent = $this->eventHandlers[get_class($event)] ?? [];
            foreach ($eventHandlersForEvent as $handler) {
                call_user_func($handler, $event);
            }
        }
    }
}
