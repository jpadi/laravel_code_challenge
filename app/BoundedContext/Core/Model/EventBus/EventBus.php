<?php

namespace App\BoundedContext\Core\Model\EventBus;

interface EventBus
{
    public function publish(Event ...$events): void;
}
